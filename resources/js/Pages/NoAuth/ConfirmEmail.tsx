import NoAuthLayout from "@/Layouts/NotAuthLayout";
import { Button } from "@/Components/ui/button";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
} from "@/Components/ui/card";

import { Head, router } from "@inertiajs/react";

export default function ConfirmEmail() {

    function resendCode() {
        console.log('Reenviar código')

        // POST con router de Inertia
    }

    function handleContinue() {
        console.log('Cierre de sesión')

        router.get(route('dashboard.usuario'))
    }

    return (
        <NoAuthLayout>
            <Head title="Confirmación de correo" />

            <Card>
                <CardHeader>
                    <CardTitle>Confirma tu  correo</CardTitle>
                    <CardDescription>Para poder iniciar sesión, primero debes ingresar al link que ha sido enviado a tu correo.</CardDescription>
                    <CardContent className="p-0 space-y-4 space-x-6">
                        <Button onClick={handleContinue} >
                            Continuar
                        </Button>
                        <Button onClick={resendCode} variant={'outline'}>
                            Reenviar correo
                        </Button>
                    </CardContent>
                </CardHeader>
            </Card>
        </NoAuthLayout>
    )
}
