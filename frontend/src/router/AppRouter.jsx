import { Navigate, Route, Routes } from 'react-router-dom';
import AppLayout from '../components/layout/AppLayout';
import { useAuth } from '../context/AuthContext';
import LoginPage from '../pages/auth/LoginPage';
import RegisterPage from '../pages/auth/RegisterPage';
import DashboardPage from '../pages/dashboard/DashboardPage';
import CustomersPage from '../pages/customers/CustomersPage';
import ServicesPage from '../pages/services/ServicesPage';
import BookingsPage from '../pages/bookings/BookingsPage';
import PaymentsPage from '../pages/payments/PaymentsPage';
import SettingsPage from '../pages/settings/SettingsPage';

const Protected = ({ children }) => {
  const { user, loading } = useAuth();
  if (loading) return <p className="p-6">Loading session...</p>;
  if (!user) return <Navigate to="/login" replace />;
  return children;
};

export default function AppRouter() {
  return (
    <Routes>
      <Route path="/login" element={<LoginPage />} />
      <Route path="/register" element={<RegisterPage />} />
      <Route path="/" element={<Protected><AppLayout /></Protected>}>
        <Route index element={<DashboardPage />} />
        <Route path="customers" element={<CustomersPage />} />
        <Route path="services" element={<ServicesPage />} />
        <Route path="bookings" element={<BookingsPage />} />
        <Route path="payments" element={<PaymentsPage />} />
        <Route path="settings" element={<SettingsPage />} />
      </Route>
    </Routes>
  );
}
