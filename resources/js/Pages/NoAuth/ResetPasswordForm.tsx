import NoAuthLayout from "@/Layouts/NotAuthLayout";
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import {
  Card,
  CardHeader,
  CardDescription,
  CardTitle,
  CardContent,
} from "@/Components/ui/card";
import {
  Form,
  FormField,
  FormLabel,
  FormItem,
  FormMessage,
  FormControl,
} from "@/Components/ui/form";

import { useForm } from "react-hook-form";
import { Head, router, usePage } from "@inertiajs/react";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import InputToggleVisibility from "@/Components/Forms/InputToggleVisibility";

interface Props {
  token: string;
}

const formSchema = z
  .object({
    email: z.string().email("Correo inválido"),
    token: z.string(),
    password: z
      .string()
      .regex(
        /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-/+]).{8,}$/gm,
        "La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número, 1 símbolo y al menos 8 caracteres.",
      ),
    password_confirmation: z.string().optional(),
  })
  .refine((data) => data.password === data.password_confirmation, {
    message: "Las claves deben coincidir.",
    path: ["newClaveConfirm"],
  });

export default function ResetPasswordForm({ token }: Props) {
  const props = usePage().props;

  console.log("props: ", props);

  const form = useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      email: "",
      token: token,
      password: "",
      password_confirmation: "",
    },
  });

  function onSubmit(values: z.infer<typeof formSchema>) {
    console.log("onSubmit(): values: ", values);

    // Confirmación de clave
    console.log(
      "onSubmit(): confirmación clave: ",
      values.password === values.password_confirmation,
    );

    // Request con routes de Inertia
    router.post(route("password.update"), values);
  }

  return (
    <NoAuthLayout>
      <Head title="Restablecimiento de clave" />
      <Card>
        <CardHeader>
          <CardTitle className="lg:text-4xl">
            Restablecimiento de clave
          </CardTitle>
          <CardDescription className="lg:text-xl">
            Ingresa tu correo, la nueva clave y luego debes confirmarla.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8">
              <FormField
                control={form.control}
                name="token"
                render={({ field }) => (
                  <Input type="hidden" autoComplete="off" {...field} />
                )}
              />
              <FormField
                control={form.control}
                name="email"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel htmlFor="email">Correo</FormLabel>
                    <FormControl>
                      <Input
                        id="email"
                        autoComplete="off"
                        placeholder="ejemplo@dominio.com"
                        {...field}
                      />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
              <InputToggleVisibility
                control={form.control}
                label="Nueva Clave"
                name="password"
              />
              <InputToggleVisibility
                control={form.control}
                label="Confirmación"
                name="password_confirmation"
              />
              <Button type="submit">Validar</Button>
            </form>
          </Form>
        </CardContent>
      </Card>
    </NoAuthLayout>
  );
}
