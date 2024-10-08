import { Modelo, Perfiles, ROPO } from "@/types";
import { SortingState } from "@tanstack/react-table";

interface TableState {
  visibility?: Record<string, boolean>;
  sorting?: SortingState;
}

type TipoIdNac = "DNI" | "NIE";

export interface Persona extends Modelo {
  nombres: string;
  apellidos: string;
  tipo_id_nac: TipoIdNac;
  id_nac: string;
  email: string;
  tel: string;
  perfil: Perfiles;
  observaciones: string;
  ropo?: ROPO;
}
