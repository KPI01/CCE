import NoAuthLayout from "@/Layouts/NotAuthLayout";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { Head } from "@inertiajs/react";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
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


import { useState } from "react";
import { useForm } from "react-hook-form";
import { z } from 'zod'
import { zodResolver } from "@hookform/resolvers/zod";
import ConfirmEmailDialog from "@/Components/Forms/ConfirmEmailDialog";

const formSchemaEmail = z.object({
    email: z.string({
        required_error: 'Debes ingresar un correo.',
    }).email({ message: 'El correo debe ser válido.' }),
})

export default function ResetPassword() {


    const formEmail = useForm<z.infer<typeof formSchemaEmail>>({
        resolver: zodResolver(formSchemaEmail)
    })

    let formState = formEmail.formState.isValid

    console.log('var: formState', formState)

    function onSubmit(values: z.infer<typeof formSchemaEmail>) {
        console.log(values)
    }

    return (
        <NoAuthLayout>
            <Head title="Reseteo de clave" />
            <Card>
                <CardHeader>
                    <CardTitle className="lg:text-4xl">Restablecer clave</CardTitle>
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
                                        <FormLabel>Correo</FormLabel>
                                        <FormControl>
                                            <Input placeholder="ejemplo@dominio.com" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />
                            <Button id="btn-email" type="submit" disabled={formEmail.formState.isSubmitting}>Validar</Button>
                        </form>
                    </Form>
                </CardContent>
                <CardFooter>
                </CardFooter>
            </Card>
        </NoAuthLayout>
    )
}
