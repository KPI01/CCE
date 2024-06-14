export type UUID = `${string}-${string}-${string}-${string}-${string}`

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

type Modelo = {
    id: UUID
    created_at: string
    updated_at: string
}

export interface Persona extends Modelo {
    nombres: string
    apellidos: string
    tipo_id_nac: string
    id_nac: string
    email: string
    tel: string
    perfil: string
    observaciones: string
    ropo?: {
        id: string
        tipo: string
        caducidad?: string
        nro?: string
        tipo_aplicador?: string
    }
    empresas?: Empresa[]
}

export interface Empresa extends Modelo {
    nombre: string
    nif: string
    email: string
    tel: string
    codigo: string
    perfil: string
    direccion: string
    observaciones: string
    personas?: Persona[]
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

