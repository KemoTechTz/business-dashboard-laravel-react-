import { BarChart3, Bell, CalendarCheck2, CircleDollarSign, Settings, Users, Wrench } from 'lucide-react';
import { NavLink, Outlet } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import { useEffect, useState } from 'react';
import api from '../../api/client';

const nav = [
  ['/', 'Dashboard', BarChart3],
  ['/customers', 'Customers', Users],
  ['/services', 'Services', Wrench],
  ['/bookings', 'Bookings', CalendarCheck2],
  ['/payments', 'Payments', CircleDollarSign],
  ['/settings', 'Settings', Settings]
];

export default function AppLayout() {
  const { user, logout } = useAuth();
  const [notifications, setNotifications] = useState([]);

  useEffect(() => {
    api.get('/notifications').then((res) => setNotifications(res.data)).catch(() => setNotifications([]));
  }, []);

  const unread = notifications.filter((n) => !n.is_read).length;

  return (
    <div className="min-h-screen bg-brand-dark text-zinc-100 md:flex">
      <aside className="w-full border-r border-zinc-800 bg-zinc-950 p-4 md:w-64">
        <h1 className="text-lg font-bold text-brand-gold">KemoTech</h1>
        <p className="text-xs text-zinc-400">{user?.business?.name || 'Business Dashboard'}</p>
        <div className="mt-3 flex items-center gap-2 text-xs text-zinc-300">
          <Bell size={14} /> {unread} unread notifications
        </div>
        <nav className="mt-6 space-y-2">
          {nav.map(([to, label, Icon]) => (
            <NavLink key={to} to={to} className="flex items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-zinc-800">
              <Icon size={16} /> {label}
            </NavLink>
          ))}
        </nav>
        <button onClick={logout} className="mt-6 rounded bg-brand-gold px-3 py-2 text-sm font-semibold text-black">Logout</button>
      </aside>
      <main className="flex-1 p-4 md:p-8">
        <Outlet />
      </main>
    </div>
  );
}
