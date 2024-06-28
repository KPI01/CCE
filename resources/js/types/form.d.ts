interface ConstructorProps {
  id: string;
  withLabel?: boolean;
  label: string;
  name: string;
  value: string | number | readonly string[] | undefined;
  onChange: (...events: any[]) => void;
  disabled?: boolean;
  placeholder?: string;
  className?: string;
  style?: React.CSSProperties;
  descrip?: string;
}
