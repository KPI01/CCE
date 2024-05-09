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
        required_error: 'Este campo es obligatorio',
    }).email({ message: 'Debes ingresar un correo' }),
})

export default function ResetPassword() {

    let [showDialog, setShowDialog] = useState(false)

    const formEmail = useForm<z.infer<typeof formSchemaEmail>>({
        resolver: zodResolver(formSchemaEmail),
        defaultValues: {
            email: '',
        }
    })

    let formState = formEmail.formState.isValid

    console.log('<ResetPassword>', 'var: formState', formState)

    function handleShowDialog(val: boolean) {
        if (formState === true) {
            setShowDialog(val)
        }
    }

    function sendCode(values: z.infer<typeof formSchemaEmail>) {
        console.log('<ResetPassword>', 'sendCode(values): ', values)

        // POST con router de Inertia para enviar correo
    }

    // function onSubmit(values: z.infer<typeof formSchema>) 
    // {
    //     console.log(values)        
    // }

    return (
        <NoAuthLayout>
            <Head title="Reseteo de clave" />
            <Card>
                <CardHeader>
                    <CardTitle className="lg:text-4xl">Reseteo de clave</CardTitle>
                    <CardDescription className="lg:text-xl">Para poder reestablecer tu clave, primero ingresa tu email.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Form {...formEmail}>
                        <form onSubmit={formEmail.handleSubmit(sendCode)} className="space-y-8">
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
                            <Button onClick={() => handleShowDialog(true)} type="submit" disabled={formEmail.formState.isSubmitting}>Validar</Button>
                        </form>
                    </Form>
                </CardContent>
                <CardFooter>
                    <ConfirmEmailDialog canOpen={formState} open={showDialog} callback={handleShowDialog} />
                </CardFooter>
            </Card>
        </NoAuthLayout>
    )
}