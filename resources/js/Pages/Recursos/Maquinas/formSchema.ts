import { z } from "zod";
import {
  BE_VALID_MSG,
  MAX_MESSAGE,
  MIN_MESSAGE,
  NOT_CONTAIN_MSG,
  ONLY_CONTAIN_MSG,
  REQUIRED_MSG,
} from "../utils";

export const RECURSO = "maquina";

const JUST_NUMBERS_UPPERLETTERS_REGEX = /^[A-Z0-9]+$/gm;

const NOT_NUMBERS_NOR_SYMBOLS_REGEX =
  /^[^(0-9!"·$%&/()=?¿¡'\-._,{}\[\]\(\)\^|@#\\)\n]+$/gm;

export const formSchema = z.object({
  id: z.string().nullish(),
  nombre: z
    .string({
      required_error: REQUIRED_MSG("El nombre"),
      invalid_type_error: BE_VALID_MSG("El nombre"),
    })
    .min(1, REQUIRED_MSG("El nombre"))
    .min(3, MIN_MESSAGE(3))
    .max(100, MAX_MESSAGE(100))
    .regex(
      /^[^!"·$%/\\=+\-*\[\]\{\}\n]*$/gm,
      NOT_CONTAIN_MSG("El nombre", [
        "!",
        '"',
        "·",
        "%",
        "/",
        "\\",
        "=",
        "+",
        "-",
        "*",
        "[]",
        "{}",
      ]),
    ),
  matricula: z
    .string({
      required_error: REQUIRED_MSG("La matrícula", "a"),
      invalid_type_error: BE_VALID_MSG("La matrícula"),
    })
    .min(1, REQUIRED_MSG("La matrícula", "a"))
    .min(8, MIN_MESSAGE(8))
    .max(10, MAX_MESSAGE(10))
    .regex(
      JUST_NUMBERS_UPPERLETTERS_REGEX,
      ONLY_CONTAIN_MSG("La matrícula", ["letras mayúsculas", "números"]),
    ),
  tipo: z
    .string({
      required_error: REQUIRED_MSG("El tipo de máquina"),
      invalid_type_error: BE_VALID_MSG("El tipo de máquina"),
    })
    .min(1, REQUIRED_MSG("El tipo de máquina")),
  modelo: z
    .string()
    .max(50, MAX_MESSAGE(50))
    .regex(
      NOT_NUMBERS_NOR_SYMBOLS_REGEX,
      NOT_CONTAIN_MSG("El modelo", ["caracteres especiales", "números"]),
    )
    .optional(),
  marca: z
    .string()
    .max(50, MAX_MESSAGE(50))
    .regex(
      NOT_NUMBERS_NOR_SYMBOLS_REGEX,
      NOT_CONTAIN_MSG("La marca", ["caracteres especiales", "números"]),
    )
    .optional(),
  roma: z.string().optional(),
  nro_serie: z
    .string()
    .regex(
      JUST_NUMBERS_UPPERLETTERS_REGEX,
      ONLY_CONTAIN_MSG("El Nro. de Serie", ["letras mayúsculas", "números"]),
    )
    .optional(),
  fabricante: z.string().max(50, MAX_MESSAGE(50)).optional(),
  cad_iteaf: z
    .date({
      invalid_type_error: BE_VALID_MSG("Este campo"),
    })
    .optional(),
  observaciones: z.string().max(1000, MAX_MESSAGE(1000)).optional(),
});
