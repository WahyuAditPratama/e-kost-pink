package com.app.kostpink.adapter;

import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.RecyclerView;

import com.app.kostpink.R;
import com.app.kostpink.model.Room;

import java.util.List;

public class RoomAdapter extends RecyclerView.Adapter<RoomAdapter.RoomViewHolder> {

    private List<Room> list;
    private OnRoomClickListener listener;

    public interface OnRoomClickListener {
        void onRoomClick(Room room);
    }

    public RoomAdapter(List<Room> list, OnRoomClickListener listener) {
        this.list = list;
        this.listener = listener;
    }

    @NonNull
    @Override
    public RoomViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_room, parent, false);
        return new RoomViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull RoomViewHolder holder, int position) {
        Room room = list.get(position);
        holder.tvNamaRoom.setText(room.getNamaRoom());
        holder.tvHarga.setText("Rp " + room.getHargaBulanan());
        holder.tvStatus.setText(room.getStatus());

        // Warna background berdasarkan status
        if (room.getStatus().equalsIgnoreCase("tersedia")) {
            holder.cardView.setCardBackgroundColor(Color.parseColor("#A5D6A7")); // hijau
            holder.tvStatus.setTextColor(Color.parseColor("#A5D6A7")); // hijau
        } else if (room.getStatus().equalsIgnoreCase("disewa")) {
            holder.cardView.setCardBackgroundColor(Color.parseColor("#BDBDBD")); // abu-abu
            holder.tvStatus.setTextColor(Color.parseColor("#C61616")); // hijau
        } else if (room.getStatus().equalsIgnoreCase("maintenance")) {
            holder.tvStatus.setTextColor(Color.parseColor("#C61616")); // hijau
            holder.cardView.setCardBackgroundColor(Color.parseColor("#FFF59D")); // kuning
        }

        holder.itemView.setOnClickListener(v -> {
            if (listener != null) {
                listener.onRoomClick(room);
            }
        });
    }

    @Override
    public int getItemCount() {
        return list.size();
    }

    static class RoomViewHolder extends RecyclerView.ViewHolder {
        TextView tvNamaRoom, tvHarga, tvStatus;
        CardView cardView;

        public RoomViewHolder(@NonNull View itemView) {
            super(itemView);
            tvNamaRoom = itemView.findViewById(R.id.tvNamaRoom);
            tvHarga = itemView.findViewById(R.id.tvHarga);
            tvStatus = itemView.findViewById(R.id.tvStatus);
            cardView = (CardView) itemView;
        }
    }
}

