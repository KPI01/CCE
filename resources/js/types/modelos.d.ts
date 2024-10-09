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

export interface Cultivo extends Modelo {
  nombre: string;
  variedad: string;
}
