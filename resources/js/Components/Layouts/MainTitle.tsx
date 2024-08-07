interface Props {
  title: string;
  id?: string;
}

export default function MainTitle({ title, id }: Props) {
  const toId = !id ? `${title.replace(/\s/g, "-")}` : id;
  return (
    <h1 id={toId} className="mb-3 text-4xl font-semibold">
      {title}
    </h1>
  );
}
