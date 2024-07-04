import { cn } from "@/lib/utils";
import { Button } from "../ui/button";
import {
  FormControl,
  FormDescription,
  FormItem,
  FormLabel,
  FormMessage,
} from "../ui/form";
import { Popover, PopoverContent, PopoverTrigger } from "../ui/popover";
import { format } from "date-fns";
import { Input } from "../ui/input";
import { CalendarDays } from "lucide-react";
import { Calendar } from "../ui/calendar";
import { es } from "date-fns/locale";

interface Props extends Omit<ConstructorProps, "value"> {
  id: string;
  name: string;
  onChange: (...events: any[]) => void;
  label: string;
  withLabel?: boolean;
  itemClass?: string;
  itemStyle?: React.CSSProperties;
  triggerClass?: string;
  triggerStyle?: React.CSSProperties;
  value: Date | null;
}

export default function FormDatePickerConstructor({
  id,
  name,
  value,
  onChange,
  label,
  itemClass,
  itemStyle,
  withLabel = true,
  triggerClass,
  triggerStyle,
  descripcion,
  disabled = false,
}: Props) {
  const toId = id.includes(".") ? id.replace(".", "_") : id;
  const labelId = `label-${toId}`;
  const inputId = `input-${toId}`;
  const triggerId = `trigger-${toId}`;
  const calId = `calendar-${toId}`;

  const Label = (
    <FormLabel id={labelId} htmlFor={triggerId} className="leading-4">
      {label}
    </FormLabel>
  );

  const Descripcion = descripcion && (
    <FormDescription className="col-start-2 select-none text-xs">
      {descripcion}
    </FormDescription>
  );

  const customItemClass = cn("grid gap-x-2 items-center", itemClass);
  const customStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };
  const customTriggerClass = cn("grid items-center", triggerClass);
  const customTriggerStyle = {
    gridTemplateColumns: "15ch 1fr",
    marginTop: 0,
    ...triggerStyle,
  };

  return (
    <FormItem className={customItemClass} style={customStyle}>
      {withLabel && Label}
      <Popover>
        <PopoverTrigger
          disabled={disabled}
          className={customTriggerClass}
          style={customTriggerStyle}
          asChild
        >
          <FormControl>
            <Button
              id={triggerId}
              variant={"outline"}
              className={cn(
                "mt-0 pl-3 text-left font-normal",
                !value && "text-muted-foreground",
              )}
              value={value ? format(value, "dd/MM/yyyy") : "dd/mm/aaaa"}
            >
              <span>{value ? format(value, "dd/MM/yyyy") : "dd/mm/aaaa"}</span>
              <Input
                id={inputId}
                type="hidden"
                name={name}
                value={value ? format(value, "yyyy-MM-dd") : ""}
                onChange={onChange}
              />
              <CalendarDays className="ml-auto h-4 w-4 opacity-50" />
            </Button>
          </FormControl>
        </PopoverTrigger>
        <PopoverContent className="w-auto p-0" align="start">
          <Calendar
            id={calId}
            mode="single"
            locale={es}
            selected={value === null ? undefined : value}
            onSelect={onChange}
            disabled={(date) => date < new Date()}
          />
        </PopoverContent>
      </Popover>
      {descripcion && Descripcion}
      <FormMessage id={`${id}-message`} className="col-start-1" />
    </FormItem>
  );
}
