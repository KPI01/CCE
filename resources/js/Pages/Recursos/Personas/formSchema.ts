import { z } from "zod";
import {
  BE_VALID_MSG,
  MAX_MESSAGE,
  MIN_MESSAGE,
  ONLY_CONTAIN_MSG,
  REQUIRED_MSG,
} from "../utils";

export const RECURSO = "persona";

export const TIPOS_ID_NAC = ["DNI", "NIE"];
const TIPOS_ID_NAC_READONLY = ["DNI", "NIE"] as const;
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

const LETRAS_REGEX = /^[A-Za-záéíóúÁÉÍÓÚñÑ ]*$/gm;
const ROPO_NRO_REGEX =
  /^([\d]{7,12}[SASTU]*([/][\d]{1,3})?|[\d]{1,3}[/][\d]{1,3})$/gm;
const TEL_REGEX =
  /^((\+34|0034|34)?[6|7|8|9]\d{8}|(800|900)\d{6,7}|(901|902|905|803|806|807)\d{6})$/;

export const formSchema = z
  .object({
    id: z.string().optional(),
    nombres: z
      .string({
        required_error: REQUIRED_MSG("El nombre"),
        invalid_type_error: REQUIRED_MSG("El nombre"),
      })
      .min(1, REQUIRED_MSG("El nombre"))
      .min(3, MIN_MESSAGE(3))
      .max(50, MAX_MESSAGE(50))
      .regex(LETRAS_REGEX, ONLY_CONTAIN_MSG("El nombre", ["letras"])),
    apellidos: z
      .string({
        required_error: REQUIRED_MSG("El apellido"),
        invalid_type_error: BE_VALID_MSG("El apellido"),
      })
      .min(1, REQUIRED_MSG("El apellido"))
      .min(3, MIN_MESSAGE(3))
      .max(50, MAX_MESSAGE(50))
      .regex(LETRAS_REGEX, ONLY_CONTAIN_MSG("El apellido", ["letras"])),
    tipo_id_nac: z.enum(TIPOS_ID_NAC_READONLY, {
      invalid_type_error: BE_VALID_MSG("El tipo de identificación"),
    }),
    id_nac: z
      .string({
        required_error: REQUIRED_MSG("La identificación", "a"),
      })
      .min(1, REQUIRED_MSG("La identificación"))
      .max(12, MAX_MESSAGE(12)),
    email: z
      .string({
        required_error: REQUIRED_MSG("El correo"),
      })
      .min(1, REQUIRED_MSG("El correo"))
      .email(BE_VALID_MSG("El correo")),
    tel: z.string().regex(TEL_REGEX, BE_VALID_MSG("El teléfono")).optional(),
    perfil: z
      .enum(PERFILES_READONLY, {
        invalid_type_error: BE_VALID_MSG("El perfil"),
      })
      .default("Productor"),
    observaciones: z.string().max(1000, MAX_MESSAGE(1000)).optional(),
    ropo: z
      .object({
        capacitacion: z
          .enum(CAPACITACIONES_READONLY, {
            invalid_type_error: BE_VALID_MSG("La capacitación ROPO", "a"),
          })
          .optional(),
        caducidad: z
          .date({
            invalid_type_error: BE_VALID_MSG(
              "La fecha de caducidad del carné ROPO",
              "a",
            ),
          })
          .optional(),
        nro: z
          .string({
            invalid_type_error: BE_VALID_MSG(
              "El número de identificación del carné ROPO",
            ),
          })
          .regex(ROPO_NRO_REGEX, BE_VALID_MSG("La identificación ROPO", "a"))
          .optional(),
      })
      .optional()
      .superRefine((data, ctx) => {
        if (data?.nro && !data?.capacitacion) {
          ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: REQUIRED_MSG("La capacitación ROPO", "a"),
            path: ["capacitacion"],
          });
        } else if (!data?.nro && data?.capacitacion) {
          ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: REQUIRED_MSG("La identificación ROPO"),
            path: ["nro"],
          });
        }
      }),
  })
  .superRefine((data, ctx) => {
    let tipo_id = data.tipo_id_nac;
    let id = data.id_nac;
    let regex;

    if (tipo_id === "DNI") {
      regex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]{1}$/;
    } else if (tipo_id === "NIE") {
      regex = /^[XYZ]{1}[0-9]{7}[XYZ]{1}$/;
    }

    if (!regex?.test(id)) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: BE_VALID_MSG("La identificación", "a"),
        path: ["id_nac"],
      });
    }
  });
