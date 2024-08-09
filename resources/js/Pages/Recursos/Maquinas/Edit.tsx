import { Aux, Breadcrumbs, Maquina } from "@/types";
import { formSchema } from "./formSchema";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import {
  CONTAINER_CLASS,
  DeleteIcon,
  EditIcon,
  MaquinaIcon,
  SaveUpdateIcon,
  TablaIcon,
  nullToUndefined,
  toSend,
  urlWithoutId,
} from "../utils";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import { z } from "zod";
import { Form, FormField } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import FormButton from "@/Components/Forms/FormButton";
import { router } from "@inertiajs/react";
import { useToast } from "@/Components/ui/use-toast";

const schema = formSchema;

interface Props {
  data: Maquina;
  aux: Aux;
}

export default function Edit({ data, aux }: Props) {
  data = nullToUndefined(data);
  const { toast } = useToast();
  const breadcrumb: Breadcrumbs[] = [
    {
      icon: <TablaIcon />,
      text: "Tabla",
      url: urlWithoutId(data.url),
    },
    {
      icon: <MaquinaIcon />,
      text: "Máquina",
      url: data.url,
    },
    {
      icon: <EditIcon />,
      text: "Editando...",
      url: `${data.url}/edit`,
    },
  ];

  data.cad_iteaf = data.cad_iteaf ? new Date(data.cad_iteaf) : data.cad_iteaf;
  console.debug(schema.safeParse(data));

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: { ...data },
  });

  function handleDelete() {
    router.delete(data.url);
  }

  function onSubmit(values: z.infer<typeof schema>) {
    const dirty = form.formState.dirtyFields;
    const parsed = schema.parse(values);
    console.log("Enviando formulario...");
    console.log(parsed);

    const justDirty = toSend(dirty, parsed);

    if (Object.keys(justDirty).length > 0) {
      console.debug("Enviando solo los campos modificados...");
      router.patch(data.url, justDirty);
    } else {
      toast({
        title: "No se han detectado cambios!",
        variant: "muted",
        customId: "edit-sin_cambios",
      });
    }
  }

  return (
    <FormLayout
      pageTitle="Editando: Máquina"
      mainTitle="Máquina"
      created_at={data.created_at}
      updated_at={data.updated_at}
      id={data.id}
      url={data.url}
      showActions={false}
      breadcrumbs={breadcrumb}
    >
      <Form {...form}>
        <form
          id={`edit-${data.id}`}
          onSubmit={form.handleSubmit(onSubmit)}
          className={CONTAINER_CLASS}
        >
          <FormField
            control={form.control}
            name="nombre"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Nombres"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="matricula"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Matrícula"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="nro_serie"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Nro. de Serie"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="tipo"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                label="Tipo"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
                options={aux.tipos || []}
              />
            )}
          />
          <FormField
            control={form.control}
            name="fabricante"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Fabricante"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="marca"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Marca"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="modelo"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Modelo"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="roma"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Cod. ROMA"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
              />
            )}
          />
          <FormField
            control={form.control}
            name="cad_iteaf"
            render={({ field }) => (
              <FormDatePickerConstructor
                id={field.name}
                label="Caducidad del ITEAF"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
                resetBtn
                resetFn={() =>
                  form.setValue(field.name, undefined, {
                    shouldValidate: true,
                    shouldDirty: true,
                    shouldTouch: true,
                  })
                }
              />
            )}
          />
          <FormField
            control={form.control}
            name="observaciones"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Observaciones"
                name={field.name}
                value={field.value}
                onChange={field.onChange}
                textarea
              />
            )}
          />
          <div className="col-span-full flex items-center gap-16">
            <FormButton
              variant={"destructive"}
              className="ms-auto"
              onClick={handleDelete}
            >
              <DeleteIcon />
              Eliminar
            </FormButton>
            <FormButton type="submit">
              <SaveUpdateIcon />
              Actualizar
            </FormButton>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
