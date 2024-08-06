import { Aux, Breadcrumbs, Maquina } from "@/types";
import { formSchema } from "./formSchema";
import { useForm } from "react-hook-form";
import { z } from "zod";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import { Form, FormField } from "@/Components/ui/form";
import { CONTAINER_CLASS, MaquinaIcon, TablaIcon } from "../utils";
import FormTitle from "@/Components/Forms/FormTitle";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";

const schema = formSchema;

export default function Show({ data, aux }: { data: Maquina; aux: Aux }) {
  const breadcrumb: Breadcrumbs[] = [
    {
      icon: TablaIcon,
      text: "Tabla",
      url: data.urls.index,
    },
    {
      icon: MaquinaIcon,
      text: "Máquina",
      url: data.urls.show,
    },
  ];

  data.cad_iteaf = data.cad_iteaf ? new Date(data.cad_iteaf) : data.cad_iteaf;
  schema.safeParse(data);

  const form = useForm<z.infer<typeof schema>>({
    defaultValues: { ...data },
  });

  return (
    <FormLayout
      id={data.id}
      pageTitle="Maquina"
      mainTitle={data.nombre}
      created_at={data.created_at}
      updated_at={data.updated_at}
      urls={data.urls}
      breadcrumbs={breadcrumb}
    >
      <Form {...form}>
        <form id={`show-${data.id}`} className={CONTAINER_CLASS}>
          <div className="col-span-full">
            <FormTitle id="h3-general" title="Información de la máquina" />
            <div className="space grid grid-cols-2 gap-x-12 gap-y-6">
              <FormField
                control={form.control}
                name="matricula"
                render={({ field }) => (
                  <FormItemConstructor
                    id={field.name}
                    name={field.name}
                    label="Matrícula"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="nro_serie"
                render={({ field }) => (
                  <FormItemConstructor
                    id={field.name}
                    name={field.name}
                    label="Nro. de Serie"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="tipo"
                render={({ field }) => (
                  <FormItemSelectConstructor
                    id={field.name}
                    name={field.name}
                    label="Tipo"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
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
                    name={field.name}
                    label="Fabricante"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="modelo"
                render={({ field }) => (
                  <FormItemConstructor
                    id={field.name}
                    name={field.name}
                    label="Modelo"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="marca"
                render={({ field }) => (
                  <FormItemConstructor
                    id={field.name}
                    name={field.name}
                    label="Marca"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="roma"
                render={({ field }) => (
                  <FormItemConstructor
                    id={field.name}
                    name={field.name}
                    label="Cód. ROMA"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="cad_iteaf"
                render={({ field }) => (
                  <FormDatePickerConstructor
                    id={field.name}
                    name={field.name}
                    label="Matrícula"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                  />
                )}
              />
              <FormField
                control={form.control}
                name="observaciones"
                render={({ field }) => (
                  <FormItemConstructor
                    id={field.name}
                    name={field.name}
                    label="Observaciones"
                    onChange={field.onChange}
                    value={field.value}
                    disabled={true}
                    textarea
                  />
                )}
              />
            </div>
          </div>
        </form>
      </Form>
    </FormLayout>
  );
}
