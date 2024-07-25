type UUID = `${string}-${string}-${string}-${string}-${string}`;

interface Modelo {
  id: UUID;
  created_at: Date;
  updated_at: Date;
}

type Perfiles = "Productor" | "Aplicador" | "Operario";

type Capacitaciones =
  | ""
  | "Básico"
  | "Cualificado"
  | "Fumigador"
  | "Piloto Aplicador";

type ROPO = {
  caducidad?: Date | null;
  nro?: string;
  capacitacion?: Capacitaciones;
};

export interface User extends Modelo {
  name: string;
  email: string;
  email_verified_at: string;
}

export interface Persona extends Modelo {
  nombres: string;
  apellidos: string;
  tipo_id_nac: "DNI" | "NIE";
  id_nac: string;
  email: string;
  tel: string;
  perfil: Perfiles;
  observaciones: string;
  ropo?: ROPO;
}

export interface Empresa extends Modelo {
  nombre: string;
  nif: string;
  email: string;
  tel: string;
  codigo: string;
  perfil: Perfiles;
  direccion: string;
  observaciones: string;
  ropo?: ROPO;
}
