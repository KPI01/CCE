import NoAuthLayout from "@/Layouts/NotAuthLayout";

import { Link, Head } from "@inertiajs/react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from 'zod'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/Components/ui/card"
import { Button } from "@/Components/ui/button"
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form"
import { Input } from "@/Components/ui/input"

const formSchema = z.object({
    email: z.string({
        required_error: 'Este campo es requerido',
        invalid_type_error: 'Debes ingresar un correo válido',
    }).email(
        'Debes ser un correo válido'
    ).min(5, 'El correo debe ser más largo'),
    password: z.string(),
})

export default function Login() {

    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            email: '',
            password: '',
        }
    })

    function onSubmit(values: z.infer<typeof formSchema>) {
        console.log(values)
    }

    return (
        <NoAuthLayout>
            <Head title="Inicio de Sesión"/>
            <Card className="w-3/4 lg:w-full mx-auto">
                <CardHeader>
                    <CardTitle className="lg:text-4xl">Inicio de Sesión</CardTitle>
                    <CardDescription className="lg:text-xl">Para poder utilizar la aplicación, primero debes identificarte.</CardDescription>
                </CardHeader>
                <CardContent>
                    <Form {...form}>
                        <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8">
                            <FormField
                                control={form.control}
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
                            <FormField
                                control={form.control}
                                name="password"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Clave</FormLabel>
                                        <FormControl>
                                            <Input {...field} />
                                        </FormControl>
                                        <FormDescription>
                                            <Button className="ps-0 ms-auto" variant={'link'} asChild>
                                            <Link href='#'>¿Clave olvidada?</Link>
                                            </Button>
                                        </FormDescription>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />
                            <Button className="mx-auto" type="submit">Iniciar sesión</Button>
                        </form>
                    </Form>
                </CardContent>
            </Card>
        </NoAuthLayout>
    )
}