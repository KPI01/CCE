import { Select } from "@radix-ui/react-select";
import { FormControl, FormDescription, FormItem, FormLabel, FormMessage } from "../ui/form";
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
}

export function FormItemSelectConstructor({
  id,
  label,
  name,
  value,
  options,
  placeholder = "...",
  onChange,
  disabled = false,
  withLabel = true,
  itemClass,
  itemStyle,
  TriggerClass = "",
  TriggerStyle,
  descripcion = undefined,
}: Props) {
  id = id.includes(".") ? id.replace(".", "_") : id
  const triggerId = `trigger-${id}`;
  const labelId = `label-${id}`;

  const Label = (
    <FormLabel id={labelId} htmlFor={triggerId}>
      {label}
    </FormLabel>
  );

  const Descripcion = <FormDescription className="select-none text-xs col-start-2">{descripcion}</FormDescription>;

  // console.debug('params:',{
  //     id,
  //     label,
  //     name,
  //     value,
  //     options,
  //     placeholder,
  //     onChange,
  //     disabled
  // })

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
      <FormMessage id={`${name}-message`} className="col-span-full" />
    </FormItem>
  );
}
