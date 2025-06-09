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
import com.app.kostpink.activity.DetailBookingActivity;
import com.app.kostpink.activity.DetailTagihanActivity;
import com.app.kostpink.model.Tagihan;

import java.util.List;

public class TagihanAdapter extends RecyclerView.Adapter<TagihanAdapter.ViewHolder> {

    List<Tagihan> tagihanList;
    Context context;

    public TagihanAdapter(Context context, List<Tagihan> tagihanList) {
        this.context = context;
        this.tagihanList = tagihanList;
    }

    public void updateList(List<Tagihan> list) {
        this.tagihanList = list;
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_list, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Tagihan tagihan = tagihanList.get(position);

        holder.tv_item1.setText(tagihan.getDueDate());
        holder.tv_item2.setText(tagihan.getNamaRoom());
        holder.tv_item3.setText(tagihan.getHargaBulanan());
        holder.tv_item4.setText(getBulan(Integer.parseInt(tagihan.getBulan()))+" "+tagihan.getTahun());

        String status = tagihan.getStatus();
        if (status.equalsIgnoreCase("pending")) {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse));
            holder.tv_status.setText("Menunggu Pembayaran");
        } else if (status.equalsIgnoreCase("proses")) {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse2));
            holder.tv_status.setText("Menunggu Konfirmasi");
        } else if (status.equalsIgnoreCase("lunas")) {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse3));
            holder.tv_status.setText("Lunas");
        } else {
            holder.linear_status.setBackground(holder.itemView.getContext().getDrawable(R.drawable.bg_ellipse5));
            holder.tv_status.setText("Invalid");
        }
        holder.itemView.setOnClickListener(view -> {
            Intent i = new Intent(context, DetailTagihanActivity.class);
            i.putExtra("id", tagihan.getId());
            i.putExtra("no_invoice", tagihan.getNoInvoice());
            i.putExtra("bulan", tagihan.getBulan());
            i.putExtra("tahun", tagihan.getTahun());
            i.putExtra("due_date", tagihan.getDueDate());
            i.putExtra("nominal", tagihan.getNominal());
            i.putExtra("status", tagihan.getStatus());
            i.putExtra("payment_method", tagihan.getPaymentMethod() != null ? tagihan.getPaymentMethod() : "");
            i.putExtra("payment_date", tagihan.getPaymentDate() != null ? tagihan.getPaymentDate() : "");
            i.putExtra("payment_proof", tagihan.getPaymentProof() != null ? tagihan.getPaymentProof() : "");
            i.putExtra("created_at", tagihan.getCreatedAt());
            i.putExtra("updated_at", tagihan.getUpdatedAt());
            i.putExtra("id_customer", tagihan.getIdCustomer());
            i.putExtra("id_room", tagihan.getIdRoom());
            i.putExtra("start_date", tagihan.getStartDate());
            i.putExtra("end_date", tagihan.getEndDate());
            i.putExtra("harga_bulanan", tagihan.getHargaBulanan());
            i.putExtra("deposit_amount", tagihan.getDepositAmount() != null ? tagihan.getDepositAmount() : "");
            i.putExtra("nama_customer", tagihan.getNamaCustomer());
            i.putExtra("email", tagihan.getEmail());
            i.putExtra("telepon", tagihan.getTelepon());
            i.putExtra("tanggal_lahir", tagihan.getTanggalLahir());
            i.putExtra("jenis_kelamin", tagihan.getJenisKelamin());
            i.putExtra("alamat", tagihan.getAlamat());
            i.putExtra("nama_room", tagihan.getNamaRoom());
            i.putExtra("fitur", tagihan.getFitur());
            i.putExtra("deskripsi", tagihan.getDeskripsi());
            i.putExtra("visible", "yes");


            context.startActivity(i);
        });
    }

    @Override
    public int getItemCount() {
        return tagihanList == null ? 0 : tagihanList.size();
    }

    public String getBulan(int bulan) {
        String[] namaBulan = {
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        };

        if (bulan >= 1 && bulan < 12) {
            return namaBulan[bulan-1];
        } else {
            return "Bulan Tidak Valid";
        }
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tv_item1, tv_item2, tv_item3, tv_item4, tv_status;
        LinearLayout linear_status;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tv_item1 = itemView.findViewById(R.id.tv_item1);
            tv_item2 = itemView.findViewById(R.id.tv_item2);
            tv_item3 = itemView.findViewById(R.id.tv_item3);
            tv_item4 = itemView.findViewById(R.id.tv_item4);
            tv_status = itemView.findViewById(R.id.tv_status);
            linear_status = itemView.findViewById(R.id.linear_status);
        }
    }
}

