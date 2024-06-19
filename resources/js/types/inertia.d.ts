import { Persona, Empresa } from './modelos.d';

export interface Message {
    content?: string
    action?: {
        type: string
        data: Persona | Empresa
    }
    toast?: {
        variant: 'default' | 'destructive'
        title: string
        description: string
    }
}

export interface Flash {
    from: string
    message: Message
}
