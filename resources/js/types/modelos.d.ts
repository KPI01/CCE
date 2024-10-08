type UUID = `${string}-${string}-${string}-${string}-${string}`;

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

export interface Cultivo extends Modelo {
  nombre: string;
  variedad: string;
}
