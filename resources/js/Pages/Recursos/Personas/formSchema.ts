import { z } from "zod";

export const RECURSO = "persona";

const FIELD_MSG = "Este campo";
const REQUIRED_MSG = `${FIELD_MSG} es requerido.`;
const SHOULD_BE_VALID_MSG = `${FIELD_MSG} debe ser válido.`;
const TEXT_MSG = `${FIELD_MSG} debe ser solo texto.`;

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

const NOMBRES_REGEX = /^[A-Za-záéíóúÁÉÍÓÚñÑ ]*$/gm;
const ROPO_NRO_REGEX =
  /^([\d]{7,12}[SASTU]*([/][\d]{1,3})?|[\d]{1,3}[/][\d]{1,3})$/gm;
const TEL_REGEX =
  /^((\+34|0034|34)?[6|7|8|9]\d{8}|(800|900)\d{6,7}|(901|902|905|803|806|807)\d{6})$/;

export const formSchema = z
  .object({
    id: z.string().optional(),
    nombres: z
      .string({
        required_error: REQUIRED_MSG,
        invalid_type_error: TEXT_MSG,
      })
      .min(1, REQUIRED_MSG)
      .min(3, "El nombre debe tener al menos 3 caracteres.")
      .max(50, "El nombre debe tener menos de 50 caracteres.")
      .regex(NOMBRES_REGEX, "El nombre solo puede contener letras.")
      .transform((val) => (val === "" ? undefined : val)),
    apellidos: z
      .string({
        required_error: REQUIRED_MSG,
        invalid_type_error: TEXT_MSG,
      })
      .min(1, REQUIRED_MSG)
      .min(3, "El apellido debe tener al menos 3 caracteres.")
      .max(50, "El apellido debe tener menos de 50 caracteres.")
      .regex(NOMBRES_REGEX, "El apellido solo puede contener letras."),
    tipo_id_nac: z.enum(TIPOS_ID_NAC_READONLY, {
      errorMap: (issue, _ctx) => {
        switch (issue.code) {
          case "invalid_type":
            return { message: `${FIELD_MSG} debe ser solo texto` };
          case "invalid_enum_value":
            return {
              message: `${FIELD_MSG} debe ser uno de los siguientes: ${TIPOS_ID_NAC.join(", ")}`,
            };
          default:
            return { message: REQUIRED_MSG };
        }
      },
    }),
    id_nac: z
      .string({
        required_error: REQUIRED_MSG,
      })
      .min(1, REQUIRED_MSG)
      .max(12, "La identificación debe ser de 12 caracteres."),
    email: z
      .string({
        required_error: REQUIRED_MSG,
      })
      .min(1, REQUIRED_MSG)
      .email("El correo debe ser válido."),
    tel: z
      .string()
      .regex(TEL_REGEX, "El número de teléfono debe ser válido.")
      .optional(),
    perfil: z
      .enum(PERFILES_READONLY, {
        invalid_type_error: SHOULD_BE_VALID_MSG,
      })
      .default("Aplicador"),
    observaciones: z
      .string()
      .max(1000, "Las observaciones deben tener como máximo 1000 caracteres.")
      .optional(),
    ropo: z
      .object({
        capacitacion: z
          .enum(CAPACITACIONES_READONLY, {
            required_error: "Debes seleccionar el tipo de capacitación ROPO.",
            invalid_type_error: SHOULD_BE_VALID_MSG,
          })
          .optional(),
        caducidad: z
          .date({
            required_error: REQUIRED_MSG,
            invalid_type_error: "Debes ingresar una fecha válida",
          })
          .optional(),
        nro: z
          .string()
          .regex(
            ROPO_NRO_REGEX,
            "La identificación ROPO debe estar en el formato adecuado.",
          )
          .optional(),
      })
      .optional()
      .superRefine((data, ctx) => {
        if (data?.nro && !data?.capacitacion) {
          ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: "Debes ingresar una capacitación ROPO.",
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
        message: "La identificación debe tener el formato adecuado.",
        path: ["id_nac"],
      });
    }
  });
