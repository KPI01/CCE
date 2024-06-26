type UUID = `${string}-${string}-${string}-${string}-${string}`;

type Modelo = {
  id: UUID;
  created_at: Date;
  updated_at: Date;
};

type ModeloURLs = {
  edit: string;
  destroy: string;
  show: string;
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
    caducidad?: Date;
    nro?: string;
    tipo_aplicador?:
      | ""
      | "Básico"
      | "Cualificado"
      | "Fumigación"
      | "Piloto"
      | "Aplicación Fitosanitarios";
  };

  empresas?: Empresa[];
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
