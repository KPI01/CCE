import { cn } from "@/lib/utils";

export default function FormTitle({
  title,
  id,
  className,
}: {
  title: string;
  id: string;
  className?: string;
}) {
  const customClass = cn("mb-4 text-xl font-bold", className);

  return (
    <h3 id={id} className={customClass}>
      {title}
    </h3>
  );
}
