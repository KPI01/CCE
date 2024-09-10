import { Breadcrumbs } from "@/types";
import { CONTAINER_CLASS, CreateIcon, TablaIcon } from "../utils";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { formSchema } from "./formSchema";
import { zodResolver } from "@hookform/resolvers/zod";
import { router } from "@inertiajs/react";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import FormSwitchConstructor from "@/Components/Forms/FormSwitchConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { CreateFormFooter } from "@/Components/Forms/Footers";

const schema = formSchema;

interface Props {
  url: string;
}

export default function Create({ url }: Props) {
  const breadcrumb: Breadcrumbs[] = [
    { icon: <TablaIcon />, text: "Tabla", url: url },
    { icon: <CreateIcon />, text: "Creando...", url: `${url}/create` },
  ];

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
  });

  function onSubmit(values: z.infer<typeof schema>) {
    console.debug("values:", values);
    const parsed = schema.parse(values);
    router.post(url, parsed);
  }

  return (
    <FormLayout
      pageTitle="Creando: Campaña"
      mainTitle="Campaña"
      url={url}
      breadcrumbs={breadcrumb}
      showActions={false}
    >
      <Form {...form}>
        <form
          id="create-campaña"
          className={CONTAINER_CLASS}
          onSubmit={form.handleSubmit(onSubmit)}
        >
          <FormField
            control={form.control}
            name="nombre"
            render={({ field }) => (
              <FormItemConstructor
                label="Nombre *"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="is_activa"
            render={({ field }) => (
              <FormSwitchConstructor
                label="¿Activa? *"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />

          <FormField
            control={form.control}
            name="inicio"
            render={({ field }) => (
              <FormDatePickerConstructor
                label="Fecha de inicio *"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />

          <FormField
            control={form.control}
            name="fin"
            render={({ field }) => (
              <FormDatePickerConstructor
                label="Fecha final *"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />

          <FormField
            control={form.control}
            name="descripcion"
            render={({ field }) => (
              <FormItemConstructor
                label="Descripción"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                textarea
              />
            )}
          />
          <CreateFormFooter />
        </form>
      </Form>
    </FormLayout>
  );
}
