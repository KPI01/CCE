import { Breadcrumbs, Campana } from "@/types";
import { formSchema } from "./formSchema";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import {
  CONTAINER_CLASS,
  CampanaIcon,
  EditIcon,
  TablaIcon,
  convertToType,
  toSend,
  urlWithoutId,
} from "../utils";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import FormSwitchConstructor from "@/Components/Forms/FormSwitchConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import EditButtons from "@/Components/Forms/EditButtons";
import { router } from "@inertiajs/react";
import { useToast } from "@/Components/ui/use-toast";

const schema = formSchema;

export default function Edit({ data }: { data: Campana }) {
  const { toast } = useToast();

  data.inicio = convertToType({ val: data.inicio, type: "date" });
  data.fin = convertToType({ val: data.fin, type: "date" });

  const parsed = schema.parse(data);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: parsed,
  });

  const breadcrumb: Breadcrumbs[] = [
    {
      icon: <TablaIcon />,
      text: "Tabla",
      url: urlWithoutId(data.url),
    },
    {
      icon: <CampanaIcon />,
      text: "Máquina",
      url: data.url,
    },
    {
      icon: <EditIcon />,
      text: "Editando...",
      url: `${data.url}/edit`,
    },
  ];

  function onSubmit(values: z.infer<typeof schema>) {
    const parsed = schema.parse(values);
    console.log("Enviando formulario...");
    console.log(parsed);

    if (
      parsed.nombre === values.nombre &&
      parsed.inicio === values.inicio &&
      parsed.fin === values.fin
    ) {
      toast({
        title: "No se han detectado cambios!",
        variant: "muted",
        customId: "edit-sin_cambios",
      });
    }

    router.patch(data.url, parsed);
  }

  function handleDelete() {
    router.delete(data.url);
  }

  return (
    <FormLayout
      id={data.id}
      url={data.url}
      mainTitle="Campaña"
      pageTitle="Editando: Campaña"
      created_at={data.created_at}
      updated_at={data.updated_at}
      showActions={false}
      breadcrumbs={breadcrumb}
    >
      <Form {...form}>
        <form
          id={`edit-${data.id}`}
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
          <EditButtons destroyCallback={handleDelete} />
        </form>
      </Form>
    </FormLayout>
  );
}
