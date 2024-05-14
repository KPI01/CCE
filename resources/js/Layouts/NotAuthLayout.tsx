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
        'form.login': {
            text: 'Regístrate',
            uri: 'form.registro',
        },
        'form.registro': {
            text: 'Iniciar sesión',
            uri: 'form.login',
        },
        'form.reset-clave': {
            text: 'Volver',
            uri: 'form.login',
        },
    }

    console.log('vars:', `uri: ${uri}`)

    return (
        <>
            <NavBar uri={routes[uri]?.uri} txt={routes[uri]?.text} />
            <main className="basis-full grid place-content-center">
                {children}
            </main>
        </>
    )
}
