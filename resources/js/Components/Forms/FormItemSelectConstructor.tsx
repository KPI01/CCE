import { Select } from "@radix-ui/react-select";
import { FormControl, FormItem, FormLabel, FormMessage } from "../ui/form";
import { SelectContent, SelectItem, SelectTrigger, SelectValue } from "../ui/select";
import { useState } from "react";

interface Props extends ConstructorProps {
    value: string
    placeholder: string
    options: string[]
    withInput?: boolean
}

export function FormItemSelectConstructor({
    id,
    label,
    name,
    value,
    options,
    placeholder,
    onChange,
    disabled = false
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

    return (
        <FormItem className="grid grid-cols-[15ch_1fr] items-center">
            <FormLabel htmlFor={id.includes('.') ? id.replace('.', '-') : id}>{label}</FormLabel>
            <FormControl>
                <Select
                    name={name}
                    onValueChange={onChange}
                    value={value}
                    disabled={disabled}
                >
                    <FormControl >
                        <SelectTrigger id={id.includes('.') ? id.replace('.', '-') : id}>
                            <SelectValue placeholder={placeholder} />
                        </SelectTrigger>
                    </FormControl>
                    <SelectContent>
                        {options.map((val) => {
                            if (val === '') return
                            return (
                                <SelectItem key={val} value={val} >
                                        {val}
                                </SelectItem>
                            )
                        })}
                    </SelectContent>
                </Select>
            </FormControl>
            <FormMessage id={`${name}-message`} />
        </FormItem>
    )
}
