import React, { useState } from 'react';
import { FaCartPlus, FaUser,  FaBars, FaReceipt} from 'react-icons/fa';
import { GrDocumentTime } from "react-icons/gr";
import { MdDashboard } from "react-icons/md";
import logo from '../assets/logo.png'
import './Sidebar.css'; // 👈 Import the CSS

interface NavItem {
  label: string;
  icon: React.ReactNode;
  href: string;
}

const navItems: NavItem[] = [
  { label: 'Dashboard', icon: <MdDashboard />, href: '/dashboard' },
  { label: 'Order', icon: <FaCartPlus />, href: '/order' },
  { label: 'Products', icon: <FaUser />, href: 'api/products' },
  { label: 'Transaction', icon: <GrDocumentTime />, href: '/transaction' },
  { label: 'Receipt', icon: <GrDocumentTime />, href: '/receipt' },
];

const Sidebar: React.FC = () => {
  const [isOpen, setIsOpen] = useState(true);

  return (
    <div className="flex">
      {/* Sidebar */}
      <div
        className={`sidebar fixed top-0 left-0 h-screen text-white transition-all duration-300 ${
          isOpen ? 'w-64' : 'w-16'
        }`} style={{ backgroundColor: '#729156' }}
      >
        <div className="flex items-center justify-between pt-5 pl-0">
          {isOpen && <span className="text-xl font-bold"><img src={logo} alt="" /></span>}
          <button onClick={() => setIsOpen(!isOpen)} className="mr-1 text-[#FAEFC4] ml-auto" style={{ backgroundColor: '#729156' }}>
            <FaBars />
          </button>
        </div>
        <nav className="mt-4 ">
          {navItems.map((item) => (
            <a
              key={item.label}
              href={item.href}
              className="flex items-center px-4 py-2 hover:bg-[#98AB6B] "
            >
              <span className="text-lg text-[#FAEFC4]">{item.icon}</span>
              {isOpen && <span className="ml-4 text-[#FAEFC4]">{item.label}</span>}
            </a>
          ))}
        </nav>
      </div>
    </div>
  );
};

export default Sidebar;
