import MainLayout from "@/Layouts/MainLayout";

interface Props {
  data: {
    id: number;
    tipo: string;
  };
}

export default function Auxiliares({ data }: Props) {
  return <MainLayout></MainLayout>;
}
