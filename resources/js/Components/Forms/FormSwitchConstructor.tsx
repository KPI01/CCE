import {
  FormControl,
  FormDescription,
  FormItem,
  FormLabel,
  FormMessage,
} from "../ui/form";
import { Switch } from "../ui/switch";

interface Props extends Omit<ConstructorProps, "value"> {
  value: boolean;
}

export default function FormSwitchConstructor({
  name,
  value,
  disabled = false,
  onChange,
  descripcion = undefined,
  label,
  withLabel = true,
}: Props) {
  const itemId = name.includes(".") ? name.replace(".", "_") : name;
  const checkId = `check-${itemId}`;
  const labelId = `label-${itemId}`;
  const descripId = `descrip-${itemId}`;

  const Label = (
    <FormLabel id={labelId} htmlFor={checkId} className="leading-0">
      {label}
    </FormLabel>
  );

  const Descripcion = (
    <FormDescription id={descripId}>{descripcion}</FormDescription>
  );

  return (
    <FormItem className="flex flex-row items-center justify-start">
      <div className="space-y-0.5">
        {withLabel && Label}
        {Descripcion}
      </div>
      <FormControl>
        <Switch
          disabled={disabled}
          className="ms-6"
          checked={value}
          onCheckedChange={onChange}
        />
      </FormControl>
      <FormMessage id={`msg-${itemId}`} />
    </FormItem>
  );
}
