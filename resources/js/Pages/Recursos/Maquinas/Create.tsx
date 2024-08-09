import FormLayout from "@/Layouts/Recursos/FormLayout";
import { Aux, Breadcrumbs } from "@/types";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { formSchema } from "./formSchema";
import { zodResolver } from "@hookform/resolvers/zod";
import { CONTAINER_CLASS, CreateIcon, SendIcon, TablaIcon } from "../utils";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import FormButton from "@/Components/Forms/FormButton";
import { router } from "@inertiajs/react";

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
                placeholder="..."
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
                placeholder="..."
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
                placeholder="..."
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                options={aux.tipos || []}
              />
            )}
          />
          <FormField
            control={form.control}
            name="fabricante"
            render={({ field }) => (
              <FormItemConstructor
                label="Fabricante"
                placeholder="..."
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
                placeholder="..."
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
                placeholder="..."
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
                placeholder="..."
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
                placeholder="..."
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
                placeholder="..."
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
                placeholder="..."
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                textarea
              />
            )}
          />
          <FormButton type="submit" className="col-span-full ms-auto">
            <SendIcon />
            Enviar
          </FormButton>
        </form>
      </Form>
    </FormLayout>
  );
}
