import { z } from "zod";
import { BE_VALID_MSG, MAX_MESSAGE, MIN_MESSAGE, REQUIRED_MSG } from "../utils";

export const RECURSO = "empresa";

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
      required_error: REQUIRED_MSG("El nombre"),
      invalid_type_error: BE_VALID_MSG("El nombre"),
    })
    .min(1, REQUIRED_MSG("El nombre"))
    .min(3, MIN_MESSAGE(3))
    .max(100, MAX_MESSAGE(100))
    .regex(
      NOMBRE_REGEX,
      "El nombre solo puede contener letras, números, o (, . - · &).",
    ),
  nif: z
    .string({
      required_error: REQUIRED_MSG("El NIF"),
      invalid_type_error: BE_VALID_MSG("El NIF"),
    })
    .min(1, REQUIRED_MSG("El NIF"))
    .regex(/^[A-HJ-NP-SUVW][0-9]{7}[0-9A-J]$/gm, {
      message: "El NIF debe ser válido.",
    }),
  email: z
    .string({
      required_error: REQUIRED_MSG("El correo"),
      invalid_type_error: BE_VALID_MSG("El correo"),
    })
    .min(1, REQUIRED_MSG("El correo"))
    .email(BE_VALID_MSG("El correo"))
    .max(254, MAX_MESSAGE(254)),
  tel: z
    .string({
      invalid_type_error: BE_VALID_MSG("El teléfono"),
    })
    .regex(TEL_REGEX, "El número de teléfono debe ser válido.")
    .optional(),
  codigo: z
    .string()
    .regex(/^\d+$/, "El código solo puede contener números.")
    .optional(),
  perfil: z
    .enum(PERFILES_READONLY, {
      invalid_type_error: BE_VALID_MSG("El perfil"),
    })
    .default("Aplicador"),
  direccion: z.string().max(300, MAX_MESSAGE(300)).optional(),
  observaciones: z.string().max(1000, MAX_MESSAGE(1000)).optional(),
  ropo: z
    .object({
      capacitacion: z
        .enum(CAPACITACIONES_READONLY, {
          invalid_type_error: BE_VALID_MSG("La capacitación ROPO"),
        })
        .optional(),
      caducidad: z
        .date({
          invalid_type_error: BE_VALID_MSG("La caducidad del carné ROPO"),
        })
        .optional(),
      nro: z
        .string()
        .regex(ROPO_NRO_REGEX, BE_VALID_MSG("El número del carné ROPO"))
        .optional(),
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
