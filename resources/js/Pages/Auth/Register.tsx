import NoAuthLayout from "@/Layouts/NotAuthLayout";

import {useState} from 'react'
import { z } from 'zod'
import { zodResolver } from "@hookform/resolvers/zod";
import { Head } from "@inertiajs/react";
import {
    Card,
    CardHeader,
    CardContent,
    CardTitle,
    CardDescription,
    CardFooter
} from "@/Components/ui/card";
import { useForm } from "react-hook-form";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form"
import { Input } from "@/Components/ui/input"
import { Button } from "@/Components/ui/button"
import InputToggleVisibility from "@/Components/Forms/InputToggleVisibility";
import ConfirmEmailDialog from "@/Components/Forms/ConfirmEmailDialog";


const formSchema = z.object({
    name: z.string({
        required_error: 'Debes ingresar un nombre',
        invalid_type_error: 'Debes insertar un nombre',
    }).regex(/[a-zA-Z]/, {
        message: 'El nombre no debe tener números ni símbolos',
    }).min(3, 'El nombre debe tener al menos 3 caracteres'),
    email: z.string({
        required_error: 'Debes ingresar un correo',
        invalid_type_error: 'Debes insertar un correo',
    }).email('Debes insertar un correo'),
    password: z.string({
        required_error: 'Este campo es requerido',
        invalid_type_error: 'Debes insertar una clave',
    }).regex(/[a-zA-Z]{3,}[0-9]{3,}[!"@#$%&/\(\)\[\]\{\}^*+\-=?¿?`´ºª\\'¡ç]{2,}/, 'La clave debe tener al menos 3 letras (mayúsculas o minúsculas), 3 números y 2 caracteres especiales').min(8, 'La clave debe tener al menos 8 caracteres'),
    confirmPassword: z.string({
        required_error: 'Este campo es requerido',
        invalid_type_error: 'Debes insertar una clave',
    })
}).refine((data) => data.password === data.confirmPassword, {
    message: "Las claves no coinciden",
    path: ["confirmPassword"],
})

export default function Register() {

    let [showDialog, setShowDialog] = useState(false)

    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
        }
    })

    let formSubmit = form.formState.isSubmitSuccessful

    function handleShowDialog(val: boolean) {
        if (formSubmit === true) {
            setShowDialog(val)
        }
    }

    function onSubmit(values: z.infer<typeof formSchema>) {
        console.log('<Register>','onSubmit(values): ',values)

        console.log('<Register>', `onSubmit(password === confirmPassword)values.password === values.confirmPassword}`)

        // POST con router de Inertia + confirmación de clave
        // Luego de enviar el usuario a la BD implementar la confirmación del correo

        // Request va aqui

        formSubmit = form.formState.isSubmitSuccessful

        handleShowDialog(true)
    }

    return (
        <NoAuthLayout>
            <Head title="Registro" />
            <Card>
                <CardHeader>
                    <CardTitle className="lg:text-4xl">Registro</CardTitle>
                    <CardDescription className="lg:text-xl">Para poder registrar al usuario ingresa los datos adecuadamente.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Form {...form}>
                        <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8" >
                            <FormField
                                control={form.control}
                                name="name"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Nombre</FormLabel>
                                        <FormControl>
                                            <Input
                                                placeholder="Pero Perez" {...field} />
                                        </FormControl>

                                        <FormMessage />
                                    </FormItem>
                                )} />
                            <FormField
                                control={form.control}
                                name="email"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Correo</FormLabel>
                                        <FormControl>
                                            <Input
                                                type="email"
                                                placeholder="ejemplo@dominio.com" {...field} />
                                        </FormControl>

                                        <FormMessage />
                                    </FormItem>
                                )} />
                            <InputToggleVisibility label="Clave" name="password" control={form.control} />
                            <InputToggleVisibility label="Repite la clave" control={form.control} name="confitmPassword" />
                            <Button type="submit">Regístrate!</Button>
                        </form>
                    </Form>
                </CardContent>
                <CardFooter>
                    <ConfirmEmailDialog canOpen={formSubmit} open={showDialog} callback={handleShowDialog} />
                </CardFooter>
            </Card>
        </NoAuthLayout>
    )
}