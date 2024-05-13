import NoAuthLayout from "@/Layouts/NotAuthLayout";

import { useState } from "react";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { Head, router } from "@inertiajs/react";
import {
    Card,
    CardHeader,
    CardContent,
    CardTitle,
    CardDescription,
    CardFooter,
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
import ConfirmEmailDialog from "@/Components/Forms/ConfirmEmailDialog";

const formSchema = z
    .object({
        name: z
            .string({
                required_error: "Debes ingresar un nombre.",
            })
            .min(3, "El nombre debe tener al menos 3 caracteres.")
            .regex(/ \d /, {
                message: "El nombre solo puede contener letras.",
            }),
        email: z
            .string({
                required_error: "Debes ingresar un correo.",
            })
            .email("El correo debe ser válido."),
        password: z
            .string({
                required_error: "Debes ingresar una clave.",
            })
            .regex(
                / ^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-/+]).*$ /,
                "La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número y 1 símbolo."
            )
            .min(8, "La clave debe tener al menos 8 caracteres."),
        confirmPassword: z.string({
            required_error: "Debes confirmar la clave.",
        }),
    })
    .refine((data) => data.password === data.confirmPassword, {
        message: "Las claves deben coincidir.",
        path: ["confirmPassword"],
    });

interface Props {
    form_sent?: boolean;
    register_done?: boolean;
}

export default function Register(props: Props) {
    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
    });

    let dialogStartOpened = props.form_sent ? props.form_sent : false;
    console.log("var: dialogStartOpened", dialogStartOpened);

    let dialogCanOpen = props.register_done
        ? props.register_done
        : form.formState.isSubmitted;
    console.log("var: dialogCanOpen", dialogCanOpen);

    let [dialogOpen, setDialogOpen] = useState(false || dialogStartOpened);

    let formStateValid = form.formState.isValid;
    console.log("var: formStateValid", formStateValid);

    function handleShowDialog(val: boolean) {
        if (!dialogStartOpened && dialogCanOpen) {
            setDialogOpen(val);
        }
    }

    function onSubmit(values: z.infer<typeof formSchema>) {
        console.log("onSubmit(values): ", values);

        console.log(
            "onSubmit(password === confirmPassword): ",
            values.password === values.confirmPassword
        );

        // POST con router de Inertia + confirmación de clave
        // Luego de enviar el usuario a la BD implementar la confirmación del correo

        // Request va aqui
        router.post(route("nuevo_usuario"), values);

        handleShowDialog(true);
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
                            <Button type="submit">Regístrate!</Button>
                        </form>
                    </Form>
                </CardContent>
                <CardFooter>
                    <ConfirmEmailDialog
                        canOpen={dialogCanOpen}
                        open={
                            dialogStartOpened ? dialogStartOpened : dialogOpen
                        }
                        callback={handleShowDialog}
                    />
                </CardFooter>
            </Card>
        </NoAuthLayout>
    );
}
