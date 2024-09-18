import { z } from "zod";
import {
  BE_VALID_MSG,
  MIN_MESSAGE,
  NOT_CONTAIN_MSG,
  REQUIRED_MSG,
} from "../utils";

export const formSchema = z
  .object({
    nombre: z
      .string({
        required_error: REQUIRED_MSG("El nombre"),
        invalid_type_error: BE_VALID_MSG("El nombre"),
      })
      .min(1, REQUIRED_MSG("El nombre"))
      .min(4, MIN_MESSAGE(4))
      .regex(
        /^[\w]+$/,
        NOT_CONTAIN_MSG("El nombre", ["caracteres especiales"]),
      ),
    is_activa: z
      .boolean({
        required_error: REQUIRED_MSG("El estado"),
      })
      .default(false),
    inicio: z.date({
      required_error: REQUIRED_MSG("La fecha de inicio", "a"),
    }),
    fin: z.date({
      required_error: REQUIRED_MSG("La fecha final", "a"),
    }),
    descripcion: z
      .string({
        required_error: REQUIRED_MSG("La descripción", "a"),
        invalid_type_error: BE_VALID_MSG("La descripción", "a"),
      })
      .optional(),
  })
  .superRefine((data, ctx) => {
    if (data.inicio && data.fin) {
      if (data.inicio > data.fin) {
        ctx.addIssue({
          code: "invalid_date",
          message: "La fecha de inicio debe ser menor a la final",
          path: ["inicio"],
        });
      }
    }
  });
