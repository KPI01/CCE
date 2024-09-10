type UUID = `${string}-${string}-${string}-${string}-${string}`;

type Perfiles = "Productor" | "Aplicador" | "Operario";

type Capacitaciones =
  | "Básico"
  | "Cualificado"
  | "Fumigador"
  | "Piloto Aplicador"
  | undefined;

interface Modelo {
  id: UUID;
  created_at: string;
  updated_at: string;
  url: string;
}

export interface User extends Modelo {
  name: string;
  email: string;
  email_verified_at: string;
}

type ROPO = {
  caducidad?: Date;
  nro?: string;
  capacitacion?: Capacitaciones;
};

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

export interface Maquina extends Modelo {
  nombre: string;
  matricula: string;
  tipo: string;
  fabricante: string;
  modelo: string;
  marca: string;
  nro_serie: string;
  cad_iteaf: Date;
  roma: string;
  observaciones: string;
}

export interface Campana extends Modelo {
  nombre: string;
  is_activa: boolean | 0 | 1;
  inicio: string;
  fin: string;
  descripcion?: string;
}
