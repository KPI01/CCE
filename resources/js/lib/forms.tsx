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

interface FormField {
  name: string;
  label: string;
  type: string;
}

export type Methods = "post" | "put";

interface DynamicFormProps {
  stateHandler?: (state: any) => void;
  fields: FormField[];
  schema: z.ZodSchema<any>;
  onSubmit: (props: { values: any; method: Methods }) => void;
  defaults?: Record<string, any>;
  classNames?: {
    form?: string;
  };
  method: Methods;
  icon?: "create" | "update";
}

export function DynamicForm({
  fields,
  schema,
  onSubmit,
  defaults = {},
  classNames = {},
  method,
  icon = "create",
}: DynamicFormProps) {
  const form = useForm({
    resolver: zodResolver(schema),
    defaultValues: defaults,
  });
  console.debug("method:", method);

  const Icon: JSX.Element =
    icon === "create" ? <CreateIcon /> : <SaveUpdateIcon />;

  return (
    <Form {...form}>
      <form
        className={cn("flex flex-col gap-4", classNames.form)}
        onSubmit={form.handleSubmit((values) => onSubmit({ values, method }))}
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
