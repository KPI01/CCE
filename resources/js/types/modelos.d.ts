type UUID = `${string}-${string}-${string}-${string}-${string}`;


type ModeloURLs = {
  edit: string;
  destroy: string;
  show: string;
};

type Modelo = {
  id: UUID;
  created_at: Date;
  updated_at: Date;
  urls: ModeloURLs;
};

export interface User extends Modelo {
  name: string;
  email: string;
  email_verified_at: string;
}

interface ModeloRecurso extends Modelo {
  urls: ModeloURLs;
}

export interface Persona extends ModeloRecurso {
  nombres: string;
  apellidos: string;
  tipo_id_nac: "DNI" | "NIE";
  id_nac: string;
  email: string;
  tel: string;
  perfil: "" | "Aplicador" | "Técnico" | "Supervisor" | "Productor";
  observaciones: string;
  ropo?: {
    tipo: "" | "Aplicador" | "Técnico";
    caducidad?: Date | null;
    nro?: string;
    tipo_aplicador?:
      | ""
      | "Básico"
      | "Cualificado"
      | "Fumigación"
      | "Piloto"
      | "Aplicación Fitosanitarios";
  };

}

export interface Empresa extends ModeloRecurso {
  nombre: string;
  nif: string;
  email: string;
  tel: string;
  codigo: string;
  perfil: string;
  direccion: string;
  observaciones: string;
  personas?: Persona[];
}
