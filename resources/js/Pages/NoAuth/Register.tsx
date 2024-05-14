import NoAuthLayout from "@/Layouts/NotAuthLayout";
import {
    Card,
    CardHeader,
    CardContent,
    CardTitle,
    CardDescription,
} from "@/Components/ui/card";
import { useForm } from "react-hook-form";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import InputToggleVisibility from "@/Components/Forms/InputToggleVisibility";

import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { Head, router } from "@inertiajs/react";

const formSchema = z
    .object({
        name: z
            .string({
                required_error: 'Debes ingresar un nombre.',
            })
            .regex(/^[A-Za-z ]*$/gm, {
                message: 'El nombre solo puede contener letras.',
            }),
        email: z
            .string({
                required_error: 'Debes ingresar un correo.',
            })
            .email('Debes ingresar un correo.'),
        password: z
            .string({
                required_error: "Debes ingresar una clave.",
            })
            .regex(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-/+]).{8,}$/gm, 'La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número, 1 símbolo y al menos 8 caracteres.'
            ),
        confirmPassword: z.string({
            required_error: "Debes confirmar la clave.",
        }).optional(),
    })
    .refine((data) => data.password === data.confirmPassword, {
        message: "Las claves deben coincidir.",
        path: ["confirmPassword"],
    })
    .refine((data) => data.name.length > 0, {
        message: "Debes ingresar un nombre.",
        path: ["name"],
    });

interface Props {
    form_sent?: boolean;
    register_done?: boolean;
}

export default function Register(props: Props) {

    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
        },
    });

    function onSubmit(values: z.infer<typeof formSchema>) {
        console.info("onSubmit(values): ", values);

        console.info(
            "onSubmit(password === confirmPassword): ",
            values.password === values.confirmPassword
        );

        // POST con router de Inertia
        // Luego de enviar el usuario a la BD implementar la confirmación del correo
        delete values.confirmPassword

        router.post(route('store.usuario'), values)

    }

    console.log("props: ", props);

    return (
        <NoAuthLayout>
            <Head title="Registro" />
            <Card>
                <CardHeader>
                    <CardTitle className="lg:text-4xl">Registro</CardTitle>
                    <CardDescription className="lg:text-xl">
                        Para poder registrar al usuario ingresa los datos
                        adecuadamente.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form {...form}>
                        <form
                            onSubmit={form.handleSubmit(onSubmit)}
                            className="space-y-8"
                        >
                            <FormField
                                control={form.control}
                                name="name"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Nombre</FormLabel>
                                        <FormControl>
                                            <Input
                                                placeholder="Pero Perez"
                                                {...field}
                                            />
                                        </FormControl>

                                        <FormMessage />
                                    </FormItem>
                                )}
                            />
                            <FormField
                                control={form.control}
                                name="email"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Correo</FormLabel>
                                        <FormControl>
                                            <Input
                                                placeholder="ejemplo@dominio.com"
                                                {...field}
                                            />
                                        </FormControl>

                                        <FormMessage />
                                    </FormItem>
                                )}
                            />
                            <InputToggleVisibility
                                label="Clave"
                                name="password"
                                control={form.control}
                            />
                            <InputToggleVisibility
                                label="Confirma clave"
                                control={form.control}
                                name="confirmPassword"
                            />
                            <Button type="submit" >Regístrate!</Button>
                        </form>
                    </Form>
                </CardContent>
            </Card>
        </NoAuthLayout>
    );
}
