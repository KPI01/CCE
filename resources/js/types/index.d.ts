import { User } from './modelos'

export interface Auth {
    user: User;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export * from './modelos'
export * from './inertia'
export * from './components'
export * from './data-table'
