import NavBar from "@/Components/NoAuth/NavBar";

import { PropsWithChildren } from "react";

interface Routes {
    [key: string]: {
        text: string,
        uri: string
    }
}

export default function NoAuthLayout({ children }: PropsWithChildren) {
    const uri: string | '' = route().current()?.toString() || '';
    const routes: Routes = {
        'login': {
            text: 'Regístrate',
            uri: 'registro',
        },
        'registro': {
            text: 'Iniciar sesión',
            uri: 'login',
        },
        'reset_clave': {
            text: 'Volver',
            uri: 'login',
        },
    }

    console.log('vars:', `uri: ${uri}`)

    return (
        <>
            <NavBar uri={routes[uri]?.uri} txt={routes[uri]?.text} />
            <main className="h-5/6 grid place-content-center">
                {children}
            </main>
        </>
    )
}
