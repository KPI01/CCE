import { z } from "zod";
import { BE_VALID_MSG, MAX_MESSAGE, MIN_MESSAGE, REQUIRED_MSG } from "../utils";

export const RECURSO = "maquina";

export const formSchema = z.object({
  id: z.string().nullish(),
  nombre: z
    .string({
      required_error: REQUIRED_MSG("El nombre"),
      invalid_type_error: BE_VALID_MSG("El nombre"),
    })
    .min(1, REQUIRED_MSG("El nombre"))
    .min(3, MIN_MESSAGE(3))
    .max(100, MAX_MESSAGE(100)),
  matricula: z
    .string({
      required_error: REQUIRED_MSG("La matrícula"),
      invalid_type_error: BE_VALID_MSG("La matrícula"),
    })
    .min(1, REQUIRED_MSG("La matrícula"))
    .min(8, MIN_MESSAGE(8))
    .max(25, MAX_MESSAGE(25)),
  tipo: z
    .string({
      required_error: REQUIRED_MSG("El tipo de máquina"),
      invalid_type_error: BE_VALID_MSG("El tipo de máquina"),
    })
    .min(1, REQUIRED_MSG("El tipo de máquina"))
    .min(3, MIN_MESSAGE(3))
    .max(70, MAX_MESSAGE(70)),
  modelo: z.string().max(50, MAX_MESSAGE(50)).optional(),
  marca: z.string().max(50, MAX_MESSAGE(50)).optional(),
  roma: z.string().optional(),
  nro_serie: z.string().optional(),
  fabricante: z.string().max(100, MAX_MESSAGE(100)).optional(),
  cad_iteaf: z
    .date({
      invalid_type_error: BE_VALID_MSG("Este campo"),
    })
    .optional(),
  observaciones: z.string().max(300, MAX_MESSAGE(300)).optional(),
});
