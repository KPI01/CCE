import MainLayout from "@/Layouts/MainLayout";

import { Head } from "@inertiajs/react";

export default function Dashboard() {
  return (
    <MainLayout>
      <Head title="Home" />
      <h2>Bienvenido a tu Dashboard</h2>
    </MainLayout>
  );
}
