import { Select } from "@radix-ui/react-select";
import { FormControl, FormItem, FormLabel, FormMessage } from "../ui/form";
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
  selectTriggerClass?: string;
  selectTriggerStyle?: React.CSSProperties;
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
  selectTriggerClass,
  selectTriggerStyle,
}: Props) {
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

  const formItemClass = cn("grid items-center", itemClass);
  const formItemStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };

  return (
    <FormItem className={formItemClass} style={formItemStyle}>
      {withLabel && (
        <FormLabel htmlFor={id.includes(".") ? id.replace(".", "-") : id}>
          {label}
        </FormLabel>
      )}
      <FormControl>
        <Select
          name={name}
          onValueChange={onChange}
          value={value}
          disabled={disabled}
        >
          <FormControl>
            <SelectTrigger
              className={selectTriggerClass}
              style={selectTriggerStyle}
              id={id.includes(".") ? id.replace(".", "-") : id}
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
      <FormMessage id={`${name}-message`} />
    </FormItem>
  );
}
