import { z } from "zod";

export const RECURSO = "personas";
export const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-12 gap-y-4 px-32";

const FIELD_MSG = "Este campo";
const REQUIRED_MSG = `${FIELD_MSG} es requerido.`;
const SHOULD_BE_VALID_MSG = `${FIELD_MSG} debe ser válido.`;
const TEXT_MSG = `${FIELD_MSG} debe ser solo texto.`;

export const TIPOS_ID_NAC = ["DNI", "NIE"];
const TIPOS_ID_NAC_READONLY = ["DNI", "NIE"] as const;
export const PERFILES = ["", "Aplicador", "Técnico", "Supervisor", "Productor"];
const PERFILES_READONLY = [
  "",
  "Aplicador",
  "Técnico",
  "Supervisor",
  "Productor",
] as const;
export const TIPOS_ROPO = ["", "Aplicador", "Técnico"];
const TIPOS_ROPO_READONLY = ["", "Aplicador", "Técnico"] as const;
export const TIPOS_APLICADOR = [
  "",
  "Básico",
  "Cualificado",
  "Fumigación",
  "Piloto",
  "Aplicación Fitosanitarios",
];
const TIPOS_APLICADOR_READONLY = [
  "",
  "Básico",
  "Cualificado",
  "Fumigación",
  "Piloto",
  "Aplicación Fitosanitarios",
] as const;

export const formSchema = z
  .object({
    id: z.string().optional(),
    created_at: z.date().optional(),
    updated_at: z.date().optional(),
    nombres: z
      .string({
        required_error: REQUIRED_MSG,
        invalid_type_error: TEXT_MSG,
      })
      .min(3, "El nombre debe tener al menos 3 caracteres.")
      .max(50, "El nombre debe tener menos de 50 caracteres."),
    apellidos: z
      .string({
        required_error: REQUIRED_MSG,
        invalid_type_error: TEXT_MSG,
      })
      .min(3, "Los apellidos deben tener al menos 3 caracteres.")
      .max(50, "Los apellidos deben tener menos de 50 caracteres."),
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
      .max(12, "El DNI/NIE debe ser de 12 caracteres."),
    email: z
      .string({
        required_error: REQUIRED_MSG,
      })
      .email("El correo debe ser válido."),
    tel: z
      .string()
      .regex(
        /^[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}$/,
        "El teléfono debe estar en el formato indicado.",
      )
      .optional(),
    perfil: z
      .enum(PERFILES_READONLY, {
        errorMap: (issue, _ctx) => {
          switch (issue.code) {
            case "invalid_type":
              return { message: `${FIELD_MSG} debe ser solo texto` };
            case "invalid_enum_value":
              return {
                message: `${FIELD_MSG} debe ser uno de los siguientes: ${PERFILES.join(", ")}`,
              };
            default:
              return { message: SHOULD_BE_VALID_MSG };
          }
        },
      })
      .optional(),
    observaciones: z
      .string()
      .max(300, "Las observaciones deben tener menos de 300 caracteres.")
      .optional(),
    ropo: z
      .object({
        tipo: z
          .enum(TIPOS_ROPO_READONLY, {
            errorMap: (issue, _ctx) => {
              switch (issue.code) {
                case "invalid_type":
                  return { message: `${FIELD_MSG} debe ser solo texto` };
                case "invalid_enum_value":
                  return {
                    message: `${FIELD_MSG} debe ser uno de los siguientes: ${TIPOS_ROPO.join(", ")}`,
                  };
                default:
                  return { message: SHOULD_BE_VALID_MSG };
              }
            },
          })
          .optional(),
        caducidad: z.date({
          required_error: REQUIRED_MSG,
          invalid_type_error: 'Debes ingresar una fecha válida',
        }).optional(),
        nro: z.string().optional(),
        tipo_aplicador: z
          .enum(TIPOS_APLICADOR_READONLY, {
            errorMap: (issue, _ctx) => {
              switch (issue.code) {
                case "invalid_type":
                  return { message: `${FIELD_MSG} debe ser solo texto` };
                case "invalid_enum_value":
                  return {
                    message: `${FIELD_MSG} debe ser uno de los siguientes: ${TIPOS_APLICADOR.join(", ")}`,
                  };
                default:
                  return { message: SHOULD_BE_VALID_MSG };
              }
            },
          })
          .optional(),
      })
      .optional()
      .superRefine((data, ctx) => {
        if (data?.tipo && !data?.nro) {
          ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: "Debes ingresar el Nº del carnet.",
            path: ["nro"],
          });
        } else if (!data?.tipo && data?.nro) {
          ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: "Debes seleccionar el tipo de carnet.",
            path: ["tipo"],
          });
        } else if (data?.tipo && data?.nro) {
          const regex =
            /^[0-9]{5,}[A-Z]{2}[/]?[0-9]*$|^[0-9]{1,3}[/][0-9]{1,3}$/gm;

          if (!regex.test(data.nro)) {
            ctx.addIssue({
              code: z.ZodIssueCode.custom,
              message: "El Nº del carnet debe estar en el formato adecuado.",
              path: ["nro"],
            });
          }
        } else if (!data?.tipo && !data?.nro) {
          return true;
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
