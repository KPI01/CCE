import { Select } from "@radix-ui/react-select";
import {
  FormControl,
  FormDescription,
  FormItem,
  FormLabel,
  FormMessage,
} from "../ui/form";
import {
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../ui/select";
import { cn } from "@/lib/utils";

interface Props extends ConstructorProps {
  value: string;
  placeholder?: string;
  options: string[];
  itemClass?: string;
  itemStyle?: React.CSSProperties;
  TriggerClass?: string;
  TriggerStyle?: React.CSSProperties;
  open?: boolean;
}

export function FormItemSelectConstructor({
  id,
  label = "(Label)",
  name,
  value,
  options,
  placeholder = "(Vacío)",
  onChange,
  disabled = false,
  withLabel = true,
  itemClass,
  itemStyle,
  TriggerClass = "",
  TriggerStyle,
  descripcion = undefined,
  open = false,
}: Props) {
  const toId = id.includes(".") ? id.replace(".", "_") : id;
  const triggerId = `trigger-${toId}`;
  const labelId = `label-${toId}`;

  const Label = (
    <FormLabel id={labelId} htmlFor={triggerId}>
      {label}
    </FormLabel>
  );

  const Descripcion = (
    <FormDescription
      id={`descrip-${toId}`}
      className="col-start-2 select-none text-xs"
    >
      {descripcion}
    </FormDescription>
  );

  const formItemClass = cn("grid gap-x-2 items-center", itemClass);
  const formItemStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };

  return (
    <FormItem className={formItemClass} style={formItemStyle}>
      {withLabel && Label}
      <FormControl>
        <Select
          name={name}
          onValueChange={onChange}
          value={value}
          disabled={disabled}
          open={open}
        >
          <FormControl>
            <SelectTrigger
              className={TriggerClass}
              style={TriggerStyle}
              id={triggerId}
            >
              <SelectValue placeholder={placeholder} />
            </SelectTrigger>
          </FormControl>
          <SelectContent>
            {options.map((val) => {
              if (val === "") return;
              return (
                <SelectItem key={val} value={val}>
                  {val}
                </SelectItem>
              );
            })}
          </SelectContent>
        </Select>
      </FormControl>
      {descripcion && Descripcion}
      <FormMessage id={`msg-${toId}`} className="col-span-full" />
    </FormItem>
  );
}
