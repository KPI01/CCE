import NoAuthLayout from "@/Layouts/NotAuthLayout";

import { Head } from "@inertiajs/react";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from 'zod'
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
    CardFooter

} from "@/Components/ui/card"
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
        console.log('<Login>', `onSubmit(values): ${values}`)

        // POST con router de Inertia
    }

    return (
        <NoAuthLayout>
            <Head title="Inicio de Sesión" />
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
                            <InputToggleVisibility label="Clave" control={form.control} name="password" />
                            <Button type="submit">Iniciar sesión!</Button>
                        </form>
                    </Form>
                </CardContent>
                <CardFooter>
                </CardFooter>
            </Card>
        </NoAuthLayout>
    )
}