import * as React from "react"
import { cn } from "@/lib/utils"

const Toast = React.forwardRef(({ className, ...props }, ref) => (
  <div ref={ref} className={cn("p-4 bg-white border rounded shadow", className)} {...props} />
))
Toast.displayName = "Toast"

export const Toaster = () => {
  return (
    <div id="toaster" className="fixed bottom-4 right-4 z-50 flex flex-col gap-2">
      {/* Toast notifications would be rendered here */}
    </div>
  );
};

export const useToast = () => {
  return {
    toast: ({ title, description }) => {
      console.log(`Toast: ${title} - ${description}`);
      // Simple implementation for now
    }
  };
};
