package com.app.kostpink.activity;

import android.app.DatePickerDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.adapter.RoomAdapter;
import com.app.kostpink.model.BookingResponse;
import com.app.kostpink.model.FetchRoomResponse;
import com.app.kostpink.model.Room;
import com.google.android.material.bottomsheet.BottomSheetDialog;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdmRoomActivity extends AppCompatActivity {
    SharedPrefManager sharedPrefManager;

    private RecyclerView rvRoom;
    String id_user, nama_user, email, avatar;

    private SwipeRefreshLayout swipeRefresh;
    private RoomAdapter roomAdapter;
    private List<Room> listRoom = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_room);
        sharedPrefManager = new SharedPrefManager(AdmRoomActivity.this);
        id_user = sharedPrefManager.getUser().getId_user();
        nama_user = sharedPrefManager.getUser().getNama();
        email = sharedPrefManager.getUser().getEmail();
        avatar = sharedPrefManager.getUser().getAvatar();

        rvRoom = findViewById(R.id.rvRoom);
        swipeRefresh = findViewById(R.id.swipeRefresh);

        GridLayoutManager gridLayoutManager = new GridLayoutManager(this, 4);
        rvRoom.setLayoutManager(gridLayoutManager);

        roomAdapter = new RoomAdapter(listRoom, new RoomAdapter.OnRoomClickListener() {
            @Override
            public void onRoomClick(Room room) {
                if (room.getStatus().equalsIgnoreCase("tersedia")) {
                    showBottomSheet(room);
                }
            }
        });

        rvRoom.setAdapter(roomAdapter);

        swipeRefresh.setOnRefreshListener(this::fetchRooms);

        fetchRooms();
    }

    private void fetchRooms() {
        swipeRefresh.setRefreshing(true);

        // Memanggil API untuk mengambil data room
        Call<FetchRoomResponse> call = ApiClient.getInstance().getApi().fetchRoom();
        call.enqueue(new Callback<FetchRoomResponse>() {
            @Override
            public void onResponse(Call<FetchRoomResponse> call, Response<FetchRoomResponse> response) {
                if (response.isSuccessful()) {
                    // Mendapatkan list room dari response
                    listRoom = response.body().getData();
                    // Menyambungkan data ke adapter dan menampilkan di RecyclerView
                    roomAdapter = new RoomAdapter(listRoom, new RoomAdapter.OnRoomClickListener() {
                        @Override
                        public void onRoomClick(Room room) {
                                showBottomSheet(room);
                        }
                    });
                    rvRoom.setAdapter(roomAdapter);
                } else {
                    // Menampilkan pesan error jika response tidak berhasil
                    Toast.makeText(AdmRoomActivity.this, "Error: " + response.message(), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchRoomResponse> call, Throwable t) {
                // Menampilkan pesan error jika ada kesalahan dalam jaringan
                Toast.makeText(AdmRoomActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        swipeRefresh.setRefreshing(false);
    }


    private void showBottomSheet(Room room) {
        BottomSheetDialog bottomSheetDialog = new BottomSheetDialog(this);
        View view = LayoutInflater.from(this).inflate(R.layout.bottom_sheet_room, null);
        bottomSheetDialog.setContentView(view);

        TextView nama_kamar = view.findViewById(R.id.tv_nama_kamar);
        TextView deskripsi = view.findViewById(R.id.tv_deskripsi);
        TextView harga_bulanan = view.findViewById(R.id.tv_harga_bulanan);
        TextView status = view.findViewById(R.id.tv_status);

        Button btnSave = view.findViewById(R.id.btnSave);
        nama_kamar.setText(String.valueOf(room.getNamaRoom()));
        deskripsi.setText(String.valueOf(room.getDeskripsi()));
        harga_bulanan.setText(String.valueOf(room.getHargaBulanan()));
        status.setText(String.valueOf(room.getStatus()));

        btnSave.setOnClickListener(v -> {
            bottomSheetDialog.dismiss();
        });

        bottomSheetDialog.show();
    }

    private void showDatePicker(EditText editText) {
        Calendar calendar = Calendar.getInstance();
        DatePickerDialog datePickerDialog = new DatePickerDialog(this,
                (view, year, month, dayOfMonth) -> {
                    String date = year + "-" + (month + 1) + "-" + dayOfMonth;
                    editText.setText(date);
                },
                calendar.get(Calendar.YEAR),
                calendar.get(Calendar.MONTH),
                calendar.get(Calendar.DAY_OF_MONTH)
        );
        datePickerDialog.show();
    }

    public void sukses() {
        new AlertDialog.Builder(this).setTitle("Sukses").setMessage("Booking Berhasil Dibuat...").setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
                Intent intent = new Intent(AdmRoomActivity.this, MainActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();
            }
        }).show();

    }
}