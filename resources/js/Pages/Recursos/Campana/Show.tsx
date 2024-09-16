import { Breadcrumbs, Campana } from "@/types";
import { formSchema } from "./formSchema";
import { useForm } from "react-hook-form";
import { resolve } from "path";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import {
  CONTAINER_CLASS,
  CampanaIcon,
  TablaIcon,
  convertToType,
  urlWithoutId,
} from "../utils";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { Form, FormField } from "@/Components/ui/form";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import FormSwitchConstructor from "@/Components/Forms/FormSwitchConstructor";

const schema = formSchema;

export default function Show({ data }: { data: Campana }) {
  data.inicio = convertToType({
    val: data.inicio,
    type: "date",
  });
  console.debug("data.inicio convertido:", data.inicio);
  data.fin = convertToType({
    val: data.fin,
    type: "date",
  });
  console.debug("data.inicio convertido:", data.fin);

  const parsed = schema.parse(data);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    values: parsed,
  });

  const breadcrumbs: Breadcrumbs[] = [
    {
      icon: <TablaIcon />,
      text: "Tabla",
      url: urlWithoutId(data.url),
    },
    {
      icon: <CampanaIcon />,
      text: "Campaña",
      url: data.url,
    },
  ];

  return (
    <FormLayout
      id={data.id}
      pageTitle={`Campaña: ${data.nombre}`}
      mainTitle={data.nombre}
      created_at={data.created_at}
      updated_at={data.updated_at}
      url={data.url}
      breadcrumbs={breadcrumbs}
    >
      <Form {...form}>
        <form id={`show-${data.id}`} className={CONTAINER_CLASS}>
          <FormField
            control={form.control}
            name="is_activa"
            render={({ field }) => (
              <FormSwitchConstructor
                label="¿Activa?"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                disabled
              />
            )}
          />

          <FormField
            control={form.control}
            name="inicio"
            render={({ field }) => (
              <FormDatePickerConstructor
                label="Fecha de inicio"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                disabled
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
                disabled
              />
            )}
          />

          <FormField
            control={form.control}
            name="fin"
            render={({ field }) => (
              <FormDatePickerConstructor
                label="Fecha final"
                id={field.name}
                name={field.name}
                onChange={field.onChange}
                value={field.value}
                disabled
              />
            )}
          />
        </form>
      </Form>
    </FormLayout>
  );
}
