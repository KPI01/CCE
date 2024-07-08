import { z } from "zod";

export const RECURSO = "empresas";
export const CONTAINER_CLASS =
  "container grid grid-cols-2 gap-x-12 gap-y-4 px-32";

const FIELD_MSG = "Este campo";
const REQUIRED_MSG = `${FIELD_MSG} es requerido.`;
const SHOULD_BE_VALID_MSG = `${FIELD_MSG} debe ser válido.`;
const TEXT_MSG = `${FIELD_MSG} debe ser solo texto.`;

export const PERFILES = ["", "Aplicador", "Técnico", "Supervisor", "Productor"];
const PERFILES_READONLY = [
  "",
  "Aplicador",
  "Técnico",
  "Supervisor",
  "Productor",
] as const;
export const CAPACITACIONES = [
  "",
  "Básico",
  "Cualificado",
  "Fumigador",
  "Piloto Aplicador",
];
const CAPACITACIONES_READONLY = [
  "",
  "Básico",
  "Cualificado",
  "Fumigador",
  "Piloto Aplicador",
] as const;

export const formSchema = z.object({
  id: z.string().optional(),
  nombre: z
    .string({
      required_error: REQUIRED_MSG,
      invalid_type_error: TEXT_MSG,
    })
    .min(3, "El nombre debe tener al menos 3 caracteres.")
    .max(100, "El nombre debe tener menos de 50 caracteres.")
    .regex(/^[A-Za-z ]*$/gm, "El nombre solo puede contener letras."),
  nif: z
    .string({
      required_error: REQUIRED_MSG,
      invalid_type_error: TEXT_MSG,
    })
    .regex(/^[A-HJ-NP-SUVW][0-9]{7}[0-9A-J]$/gm, {
      message: "El NIF debe ser válido.",
    }),
  email: z
    .string({
      required_error: REQUIRED_MSG,
    })
    .email("El correo debe ser válido.")
    .max(254, "El correo debe ser más corto."),
  tel: z
    .string()
    .regex(
      /^((\+34|0034|34)?[6|7|8|9]\d{8}|(800|900)\d{6,7}|(901|902|905|803|806|807)\d{6})$/,
      "El número de teléfono debe ser válido.",
    )
    .optional()
    .transform((value) => (value === "" ? undefined : value)),
  codigo: z.string().regex(/^\d$/, { message: SHOULD_BE_VALID_MSG }).optional(),
  perfil: z
    .enum(PERFILES_READONLY, {
      invalid_type_error: SHOULD_BE_VALID_MSG,
    })
    .optional()
    .transform((value) => (value === "" ? undefined : value)),
  direccion: z
    .string()
    .max(300, "La dirección debe ser más corta.")
    .optional()
    .transform((value) => (value === "" ? undefined : value)),
  observaciones: z
    .string()
    .max(300, "Las observaciones deben tener menos de 300 caracteres.")
    .optional()
    .transform((value) => (value === "" ? undefined : value)),
  ropo: z
    .object({
      nro: z.string().max(55, "El nro. de ROPO debe ser más corto.").nullable(),
      caducidad: z
        .date({
          invalid_type_error: SHOULD_BE_VALID_MSG,
        })
        .optional()
        .nullable()
        .transform((value) => (value === undefined ? null : value)),
      capacitacion: z
        .enum(CAPACITACIONES_READONLY, {
          invalid_type_error: SHOULD_BE_VALID_MSG,
        })
        .optional()
        .nullable(),
    })
    .optional()
    .superRefine((data, ctx) => {
      if (data?.capacitacion && !data?.nro) {
        ctx.addIssue({
          code: z.ZodIssueCode.custom,
          message: "Debes ingresar el Nº del carnet.",
          path: ["nro"],
        });
      } else if (!data?.capacitacion && data?.nro) {
        ctx.addIssue({
          code: z.ZodIssueCode.custom,
          message: "Debes seleccionar el tipo de capacitación.",
          path: ["capacitacion"],
        });
      } else if (data?.capacitacion && data?.nro) {
        const regex =
          /^([\d]{7,12}[SASTU]*([/][\d]{1,3})?|[\d]{1,3}[/][\d]{1,3})$/gm;

        if (!regex.test(data.nro)) {
          ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: "El Nº del carnet debe estar en el formato adecuado.",
            path: ["nro"],
          });
        }
      } else if (!data?.capacitacion && !data?.nro) {
        return true;
      }
    }),
});
