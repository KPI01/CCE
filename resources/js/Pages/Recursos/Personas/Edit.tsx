import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { LayoutProps, Persona } from "@/types";
import {
  CONTAINER_CLASS,
  formSchema,
  PERFILES,
  TIPOS_ID_NAC,
  TIPOS_ROPO,
} from "./formSchema";
import { Form, FormField, FormLabel } from "@/Components/ui/form";
import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { FormItemSelectConstructor } from "@/Components/Forms/FormItemSelectConstructor";
import { useState } from "react";
import FormLayout from "@/Layouts/Recursos/FormLayout";
import FormTitle from "@/Components/Forms/FormTitle";
import FormDatePickerConstructor from "@/Components/Forms/FormDatePickerConstructor";
import { Separator } from "@/Components/ui/separator";

const schema = formSchema;

interface Props extends LayoutProps {
  data: Persona;
}
export default function Edit({ data }: Props) {
  // console.debug('data:', data);

  data.created_at = new Date(data.created_at);
  data.updated_at = new Date(data.updated_at);

  const form = useForm<z.infer<typeof schema>>({
    resolver: zodResolver(schema),
    defaultValues: {
      nombres: data.nombres,
      apellidos: data.apellidos,
      tipo_id_nac: data.tipo_id_nac,
      id_nac: data.id_nac,
      email: data.email,
      tel: data.tel || "",
      perfil: data.perfil || "",
      observaciones: data.observaciones || "",
      ropo: {
        tipo: data.ropo?.tipo || "",
        caducidad: data.ropo?.caducidad || undefined,
        nro: data.ropo?.nro || "",
        tipo_aplicador: data.ropo?.tipo_aplicador || "",
      },
    },
  });

  const [values, setValues] = useState<z.infer<typeof schema>>({
    ...form.getValues(),
  });
  console.debug("formDefaults:", form.getValues());
  console.debug("state:", values);

  function handleStateChange(key: keyof typeof values, val: typeof values) {
    console.debug("handleStateChange | key:", key, "val:", val);

    setValues({ ...values, ...val });
  }

  function onSubmit(values: z.infer<typeof schema>) {
    console.debug(values);
  }

  return (
    <FormLayout
      pageTitle="Persona"
      mainTitle="Editando..."
      created_at={data.created_at.toLocaleString()}
      updated_at={data.updated_at.toLocaleString()}
      recurso="personas"
      action="edit"
      id={data.id}
    >
      <Form {...form}>
        <form
          onSubmit={form.handleSubmit(onSubmit)}
          className={CONTAINER_CLASS}
        >
          <FormTitle title="Datos Personales" />
          <FormField
            control={form.control}
            name="nombres"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Nombres"
                name={field.name}
                value={values.nombres}
                onChange={(e) =>
                  handleStateChange("nombres", {
                    ...values,
                    nombres: e.target.value,
                  })
                }
              />
            )}
          />

          <FormField
            control={form.control}
            name="apellidos"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Apellidos"
                name={field.name}
                value={values.apellidos}
                onChange={(e) =>
                  handleStateChange("apellidos", {
                    ...values,
                    apellidos: e.target.value,
                  })
                }
              />
            )}
          />

          <div
            className="grid items-center"
            style={{ gridTemplateColumns: "15ch auto 1fr" }}
          >
            <FormLabel
              className={
                form.getFieldState("id_nac").invalid ? " text-destructive" : ""
              }
              htmlFor="id_nac"
            >
              Identificación
            </FormLabel>
            <FormField
              control={form.control}
              name="tipo_id_nac"
              render={({ field }) => (
                <FormItemSelectConstructor
                  id={field.name.replace(".", "-")}
                  name={field.name}
                  label="Tipo de identificación"
                  withLabel={false}
                  value={values.tipo_id_nac}
                  onChange={(e) => handleStateChange("tipo_id_nac", e)}
                  options={TIPOS_ID_NAC}
                  TriggerClass="w-full ml-2"
                />
              )}
            />
            <FormField
              control={form.control}
              name="id_nac"
              render={({ field }) => (
                <FormItemConstructor
                  withLabel={false}
                  id={field.name}
                  label="Identificación"
                  name={field.name}
                  onChange={(e) => handleStateChange("id_nac", e.target.value)}
                  value={values.id_nac}
                  itemClass="ml-3"
                  inputClass="col-span-2"
                />
              )}
            />
          </div>

          <FormField
            control={form.control}
            name="email"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Email"
                name={field.name}
                value={values.email}
                onChange={(e) =>
                  handleStateChange("email", {
                    ...values,
                    email: e.target.value,
                  })
                }
              />
            )}
          />

          <FormField
            control={form.control}
            name="tel"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="Teléfono"
                name={field.name}
                value={values.tel}
                onChange={(e) =>
                  handleStateChange("tel", {
                    ...values,
                    tel: e.target.value,
                  })
                }
              />
            )}
          />

          <FormField
            control={form.control}
            name="perfil"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                label="Perfil"
                name={field.name}
                value={values.perfil as string}
                onChange={(e) => setValues({ ...values, perfil: e })}
                options={PERFILES}
              />
            )}
          />

          <FormField
            control={form.control}
            name="observaciones"
            render={({ field }) => (
              <FormItemConstructor
                textarea
                id={field.name}
                label="Observaciones"
                name={field.name}
                value={values.observaciones}
                onChange={(e) =>
                  handleStateChange("observaciones", {
                    ...values,
                    observaciones: e.target.value,
                  })
                }
              />
            )}
          />

          <Separator className="col-span-full my-4" />
          <FormTitle title="Datos ROPO" />

          <FormField
            control={form.control}
            name="ropo.tipo"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                label="Tipo de carnet"
                name={field.name}
                value={values.ropo?.tipo || ""}
                onChange={(e) =>
                  handleStateChange("ropo", {
                    ...values,
                    ropo: {
                      ...values.ropo,
                      tipo: e,
                    },
                  })
                }
                options={TIPOS_ROPO}
              />
            )}
          />

          <FormField
            control={form.control}
            name="ropo.nro"
            render={({ field }) => (
              <FormItemConstructor
                id={field.name}
                label="N° de carnet"
                name={field.name}
                value={values.ropo?.nro || ""}
                onChange={(e) =>
                  handleStateChange("ropo", {
                    ...values,
                    ropo: {
                      ...values.ropo,
                      nro: e.target.value,
                    },
                  })
                }
              />
            )}
          />

          <FormField
            control={form.control}
            name="ropo.caducidad"
            render={({ field }) => (
              <FormDatePickerConstructor
                triggerClass="w-full mt-0"
                id={field.name}
                label="Fecha de caducidad"
                name={field.name}
                value={values.ropo?.caducidad}
                onChange={(e) =>
                  handleStateChange("ropo", {
                    ...values,
                    ropo: {
                      ...values.ropo,
                      caducidad: e,
                    },
                  })
                }
              />
            )}
          />

          <FormField
            control={form.control}
            name="ropo.tipo_aplicador"
            render={({ field }) => (
              <FormItemSelectConstructor
                id={field.name}
                label="Tipo de aplicador"
                name={field.name}
                value={values.ropo?.tipo_aplicador || ""}
                onChange={(e) =>
                  handleStateChange("ropo", {
                    ...values,
                    ropo: {
                      ...values.ropo,
                      tipo_aplicador: e,
                    },
                  })
                }
                options={TIPOS_ROPO}
              />
            )}
          />
        </form>
      </Form>
    </FormLayout>
  );
}
