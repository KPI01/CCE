type UUID = `${string}-${string}-${string}-${string}-${string}`

type Modelo = {
    id: UUID
    created_at: string
    updated_at: string
}

export interface User extends Modelo {
    name: string;
    email: string;
    email_verified_at: string;
}

interface ModeloRecurso extends Modelo {
    urls?: {
        edit: string
        destroy: string
        show: string
    }
}

export interface Persona extends ModeloRecurso {
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

export interface Empresa extends ModeloRecurso {
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
