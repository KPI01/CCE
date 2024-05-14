import NoAuthLayout from "@/Layouts/NotAuthLayout";
import { Button } from "@/Components/ui/button";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
} from "@/Components/ui/card";

import { Head, Link } from "@inertiajs/react";

export default function ConfirmEmail() {
    return (
        <NoAuthLayout>
            <Head title="Confirmar correo" />

            <Card>
                <CardHeader>
                    <CardTitle>Confirmación de correo</CardTitle>
                    <CardDescription>Para poder iniciar sesión, primero debes ingresar al link que ha sido enviado a tu correo.</CardDescription>
                    <CardContent className="p-0 my-5">
                        <Button asChild>
                            <Link href={route('login')}>Volver</Link>
                        </Button>
                    </CardContent>
                </CardHeader>
            </Card>
        </NoAuthLayout>
    )
}
