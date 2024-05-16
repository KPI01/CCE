import NoAuthLayout from "@/Layouts/NotAuthLayout";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle
} from "@/Components/ui/card";
import {
    Form,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
    FormControl
} from "@/Components/ui/form"

import { useForm } from "react-hook-form"
import { z } from 'zod'
import { zodResolver } from "@hookform/resolvers/zod"
import { Head, router, usePage } from "@inertiajs/react"

const formSchemaEmail = z.object({
    email: z.string()
        .email('Correo inválido.')
})


export default function ResetPasswordRequest() {

    const props = usePage().props

    console.log('props: ', props)

    const formEmail = useForm<z.infer<typeof formSchemaEmail>>({
        resolver: zodResolver(formSchemaEmail),
        defaultValues: {
            email: '',
        }
    })

    function onSubmit(values: z.infer<typeof formSchemaEmail>) {
        console.log(values)

        // POST con el router de Inertia
        router.post(route('password.email'), values)
    }

    return (
        <NoAuthLayout>
            <Head title="Petición de reinicio de clave" />
            <Card>
                <CardHeader>
                    <CardTitle className="lg:text-4xl">Petición para restablecer clave</CardTitle>
                    <CardDescription className="lg:text-xl">Para poder restablecer tu clave, primero ingresa tu correo.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Form {...formEmail}>
                        <form onSubmit={formEmail.handleSubmit(onSubmit)} className="space-y-8">
                            <FormField
                                control={formEmail.control}
                                name="email"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel htmlFor="email">Correo</FormLabel>
                                        <FormControl>
                                            <Input
                                                id="email"
                                                autoComplete="on"
                                                placeholder="ejemplo@dominio.com"
                                                {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />
                            <Button id="submit-email" type="submit">Validar</Button>
                        </form>
                    </Form>
                </CardContent>
            </Card>
        </NoAuthLayout>
    )
}
