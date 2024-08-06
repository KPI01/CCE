import { z } from "zod";

export const RECURSO = "empresa";

const REQUIRED_MSG = `Este campo es requerido.`;
const SHOULD_BE_VALID_MSG = `Este campo debe ser válido.`;
const TEXT_MSG = `Este campo debe ser solo texto.`;

export const PERFILES = ["Productor", "Aplicador", "Operario"];
const PERFILES_READONLY = ["Productor", "Aplicador", "Operario"] as const;
export const CAPACITACIONES = [
  "Básico",
  "Cualificado",
  "Fumigador",
  "Piloto Aplicador",
];
const CAPACITACIONES_READONLY = [
  "Básico",
  "Cualificado",
  "Fumigador",
  "Piloto Aplicador",
] as const;

const NOMBRE_REGEX = /^[A-Za-z0-9áéíóúÁÉÍÓÚñÑ ,.&-]*$/gm;
const ROPO_NRO_REGEX =
  /^([\d]{7,12}[SASTU]*([/][\d]{1,3})?|[\d]{1,3}[/][\d]{1,3})$/gm;
const TEL_REGEX =
  /^((\+34|0034|34)?[6|7|8|9]\d{8}|(800|900)\d{6,7}|(901|902|905|803|806|807)\d{6})$/;

export const formSchema = z.object({
  id: z.string().optional(),
  nombre: z
    .string({
      required_error: REQUIRED_MSG,
      invalid_type_error: TEXT_MSG,
    })
    .min(1, REQUIRED_MSG)
    .min(3, "El nombre debe tener al menos 3 caracteres.")
    .max(100, "El nombre debe tener menos de 50 caracteres.")
    .regex(
      NOMBRE_REGEX,
      "El nombre solo puede contener letras, números, o (, . - · &).",
    ),
  nif: z
    .string({
      required_error: REQUIRED_MSG,
      invalid_type_error: TEXT_MSG,
    })
    .min(1, REQUIRED_MSG)
    .regex(/^[A-HJ-NP-SUVW][0-9]{7}[0-9A-J]$/gm, {
      message: "El NIF debe ser válido.",
    }),
  email: z
    .string({
      required_error: REQUIRED_MSG,
    })
    .min(1, REQUIRED_MSG)
    .email("El correo debe ser válido.")
    .max(254, "El correo debe ser más corto."),
  tel: z
    .string()
    .regex(TEL_REGEX, "El número de teléfono debe ser válido.")
    .nullish()
    .or(z.literal("")),
  codigo: z
    .string()
    .regex(/^\d+$/, { message: SHOULD_BE_VALID_MSG })
    .nullish()
    .or(z.literal("")),
  perfil: z
    .enum(PERFILES_READONLY, {
      invalid_type_error: SHOULD_BE_VALID_MSG,
    })
    .default("Aplicador"),
  direccion: z
    .string()
    .max(300, "La dirección debe tener como máximo 300 caracteres.")
    .nullish(),
  observaciones: z
    .string()
    .max(1000, "Las observaciones deben tener como máximo 1000 caracteres.")
    .nullish(),
  ropo: z
    .object({
      capacitacion: z
        .enum(CAPACITACIONES_READONLY, {
          required_error: "Debes seleccionar una capacitación ROPO.",
          invalid_type_error: SHOULD_BE_VALID_MSG,
        })
        .nullish(),
      caducidad: z
        .date({
          required_error: REQUIRED_MSG,
          invalid_type_error: "Debes ingresar una fecha válida",
        })
        .nullish(),
      nro: z
        .string()
        .regex(
          ROPO_NRO_REGEX,
          "La identificación ROPO debe estar en el formato adecuado.",
        )
        .nullish(),
    })
    .optional()
    .superRefine((data, ctx) => {
      if (data?.nro && !data?.capacitacion) {
        ctx.addIssue({
          code: z.ZodIssueCode.custom,
          message: "Debes seleccionar una capacitación ROPO.",
          path: ["capacitacion"],
        });
      } else if (!data?.nro && data?.capacitacion) {
        ctx.addIssue({
          code: z.ZodIssueCode.custom,
          message: "Debes ingresar la identificación ROPO.",
          path: ["nro"],
        });
      }
    }),
});
