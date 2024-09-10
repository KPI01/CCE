import FormLayout from "@/Layouts/Recursos/FormLayout";
import { Breadcrumbs } from "@/types";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { formSchema } from "./formSchema";
import { zodResolver } from "@hookform/resolvers/zod";
import { CONTAINER_CLASS, CreateIcon, TablaIcon } from "../utils";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { router } from "@inertiajs/react";
import { CreateFormFooter } from "@/Components/Forms/Footers";

type Aux = { tipos: string[] };

interface Props {
  url: string;
  aux: Aux;
}

const schema = formSchema;

export default function Create({ aux, url }: Props) {
  const breadcrumb: Breadcrumbs[] = [
    {
      icon: <TablaIcon />,
      text: "Tabla",
      url: url,
    },
    {
      icon: <CreateIcon />,
      text: "Creando...",
      url: `${url}/create`,
    },
  ];

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      tipo: aux.tipos[0],
    },
  });

  function onSubmit(values: z.infer<typeof schema>) {
    const parsed = schema.parse(values);
    router.post(url, parsed);
  }

  return (
    <FormLayout
      pageTitle="Creando: Máquina"
      mainTitle="Máquina"
      url={url}
      breadcrumbs={breadcrumb}
      showActions={false}
    >
      <Form {...form}>
        <form
          id="create-maquina"
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
            name="matricula"
            render={({ field }) => (
              <FormItemConstructor
                label="Matrícula *"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="tipo"
            render={({ field }) => (
              <FormItemSelectConstructor
                label="Tipo *"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value || aux.tipos[0]}
                options={aux.tipos}
              />
            )}
          />
          <FormField
            control={form.control}
            name="fabricante"
            render={({ field }) => (
              <FormItemConstructor
                label="Fabricante"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="modelo"
            render={({ field }) => (
              <FormItemConstructor
                label="Modelo"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="marca"
            render={({ field }) => (
              <FormItemConstructor
                label="Marca"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="roma"
            render={({ field }) => (
              <FormItemConstructor
                label="Cod. ROMA"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="nro_serie"
            render={({ field }) => (
              <FormItemConstructor
                label="Nro. de Serie"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="cad_iteaf"
            render={({ field }) => (
              <FormDatePickerConstructor
                label="Caducidad del ITEAF"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
              />
            )}
          />
          <FormField
            control={form.control}
            name="observaciones"
            render={({ field }) => (
              <FormItemConstructor
                label="Observaciones"
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
