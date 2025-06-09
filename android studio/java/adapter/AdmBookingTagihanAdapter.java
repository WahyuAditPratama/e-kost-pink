package com.app.kostpink.adapter;


import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.app.kostpink.R;
import com.app.kostpink.activity.AdmDetailBookingActivity;
import com.app.kostpink.activity.AdmDetailBookingTagihanActivity;
import com.app.kostpink.activity.AdmTagihanBookingActivity;
import com.app.kostpink.model.Booking;

import java.util.List;

public class AdmBookingTagihanAdapter extends RecyclerView.Adapter<AdmBookingTagihanAdapter.ViewHolder> {

    List<Booking> BookingList;
    Context context;

    public AdmBookingTagihanAdapter(Context context, List<Booking> BookingList) {
        this.context = context;
        this.BookingList = BookingList;

    }

    public void updateList(List<Booking> list) {
        this.BookingList = list;
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_booking_tagihan, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {

        holder.tv_item1.setText(BookingList.get(position).getCreatedAt());
        holder.tv_item2.setText(BookingList.get(position).getNamaRoom().toString());
        holder.tv_item3.setText(BookingList.get(position).getHargaBulanan().toString());
        holder.tv_item4.setText(BookingList.get(position).getNamaCustomer().toString());

        String status = (BookingList.get(position).getStatus());
        if (status.equalsIgnoreCase("draft")) {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse));
            holder.tv_status.setText("Draft");

        } else if (status.equalsIgnoreCase("proses")) {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse2));
            holder.tv_status.setText("Menunggu Konfirmasi");

        } else if (status.equalsIgnoreCase("aktif")) {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse3));
            holder.tv_status.setText("Proses Sewa");
        } else {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse5));
            holder.tv_status.setText("Batal");
        }

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


                Intent i = new Intent(view.getContext(), AdmDetailBookingTagihanActivity.class);
                i.putExtra("id", BookingList.get(holder.getAdapterPosition()).getId());
                i.putExtra("id_customer", BookingList.get(holder.getAdapterPosition()).getIdCustomer());
                i.putExtra("id_room", BookingList.get(holder.getAdapterPosition()).getIdRoom());
                i.putExtra("start_date", BookingList.get(holder.getAdapterPosition()).getStartDate());
                i.putExtra("end_date", BookingList.get(holder.getAdapterPosition()).getEndDate());
                i.putExtra("harga_bulanan", BookingList.get(holder.getAdapterPosition()).getHargaBulanan());
                i.putExtra("status", BookingList.get(holder.getAdapterPosition()).getStatus());
                i.putExtra("deposit_amount", BookingList.get(holder.getAdapterPosition()).getDepositAmount());
                i.putExtra("catatan", BookingList.get(holder.getAdapterPosition()).getCatatan());
                i.putExtra("created_at", BookingList.get(holder.getAdapterPosition()).getCreatedAt());
                i.putExtra("updated_at", BookingList.get(holder.getAdapterPosition()).getUpdatedAt());
                i.putExtra("nama_customer", BookingList.get(holder.getAdapterPosition()).getNamaCustomer());
                i.putExtra("nama_room", BookingList.get(holder.getAdapterPosition()).getNamaRoom());
                i.putExtra("email", BookingList.get(holder.getAdapterPosition()).getEmail());
                i.putExtra("telepon", BookingList.get(holder.getAdapterPosition()).getTelepon());
                i.putExtra("alamat", BookingList.get(holder.getAdapterPosition()).getAlamat());
                i.putExtra("fitur", BookingList.get(holder.getAdapterPosition()).getFitur());
                i.putExtra("deskripsi", BookingList.get(holder.getAdapterPosition()).getDeskripsi());

                i.putExtra("visible", "yes");

                view.getContext().startActivity(i);

            }
        });

    }

    @Override
    public int getItemCount() {
        return BookingList == null ? 0 : BookingList.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        TextView tv_item1, tv_item2, tv_item3,tv_item4, tv_status;
        LinearLayout linear_status;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);

            tv_item1 = (TextView) itemView.findViewById(R.id.tv_item1);
            tv_item2 = (TextView) itemView.findViewById(R.id.tv_item2);
            tv_item3 = (TextView) itemView.findViewById(R.id.tv_item3);
            tv_item4 = (TextView) itemView.findViewById(R.id.tv_item4);
            tv_status = (TextView) itemView.findViewById(R.id.tv_status);
            linear_status = (LinearLayout) itemView.findViewById(R.id.linear_status);


        }
    }


}
