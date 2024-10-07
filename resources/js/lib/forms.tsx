import FormItemConstructor from "@/Components/Forms/FormItemConstructor";
import { Form, FormField } from "@/Components/ui/form";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { cn, ucfirst } from "./utils";
import { Button } from "@/Components/ui/button";
import { CreateIcon, SaveUpdateIcon } from "@/Pages/Recursos/utils";
import {
  DialogDescription,
  DialogHeader,
  DialogContent,
  DialogTitle,
} from "@/Components/ui/dialog";
import { router } from "@inertiajs/react";

interface FormField {
  name: string;
  label: string;
  type: string;
}

export type Methods = "post" | "put";

interface DynamicFormProps {
  fields: FormField[];
  schema: z.ZodSchema<any>;
  submitConf: { method: Methods; url: string; values?: Record<string, any> };
  defaults?: Record<string, any>;
  classNames?: {
    form?: string;
  };
  icon?: "create" | "update";
}

export function DynamicForm({
  fields,
  schema,
  defaults = {},
  classNames = {},
  icon = "create",
  submitConf,
}: DynamicFormProps) {
  const form = useForm({
    resolver: zodResolver(schema),
    defaultValues: defaults,
  });

  const Icon: JSX.Element =
    icon === "create" ? <CreateIcon /> : <SaveUpdateIcon />;

  const onSubmit = (props: { values: Record<string, any> }) => {
    const { values } = props;
    console.debug("values:", values);
    schema.parse(values);

    console.debug("submitConf:", submitConf);
    router.visit(submitConf.url, {
      method: submitConf.method,
      data: values,
    });
  };

  return (
    <Form {...form}>
      <form
        className={cn("flex flex-col gap-4", classNames.form)}
        onSubmit={form.handleSubmit((values) => onSubmit({ values }))}
      >
        {fields.map((field) => (
          <div key={field.name}>
            <FormField
              control={form.control}
              name={field.name}
              render={({ field }) => (
                <FormItemConstructor
                  id={field.name}
                  label={ucfirst(field.name)}
                  name={field.name}
                  onChange={field.onChange}
                  value={field.value}
                />
              )}
            />
          </div>
        ))}
        <Button className="ms-auto w-fit" type="submit">
          {Icon}
          Enviar
        </Button>
      </form>
    </Form>
  );
}

interface CreateDialogProps {
  children: React.ReactNode;
  title: string;
  description?: string;
}

export function CreateDialog({
  children,
  title = "Crear",
  description,
}: CreateDialogProps) {
  return (
    <DialogContent>
      <DialogHeader>
        <DialogTitle>{title}</DialogTitle>
        {description !== undefined && (
          <DialogDescription>{description}</DialogDescription>
        )}
      </DialogHeader>
      {children}
    </DialogContent>
  );
}
