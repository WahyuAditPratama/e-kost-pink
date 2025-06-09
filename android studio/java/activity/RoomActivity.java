package com.app.kostpink.activity;

import android.app.DatePickerDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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
import com.app.kostpink.model.UpdateProfileResponse;
import com.google.android.material.bottomsheet.BottomSheetDialog;

import java.io.File;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class RoomActivity extends AppCompatActivity {
    SharedPrefManager sharedPrefManager;

    private RecyclerView rvRoom;
    String id_customer, nama_customer, email, telepon, avatar;

    private SwipeRefreshLayout swipeRefresh;
    private RoomAdapter roomAdapter;
    private List<Room> listRoom = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_room);
        sharedPrefManager = new SharedPrefManager(RoomActivity.this);
        id_customer = sharedPrefManager.getCustomer().getId_customer();
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        avatar = sharedPrefManager.getCustomer().getAvatar();
        telepon = sharedPrefManager.getCustomer().getTelepon();

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
                            if (room.getStatus().equalsIgnoreCase("tersedia")) {
                                showBottomSheet(room);
                            }
                        }
                    });
                    rvRoom.setAdapter(roomAdapter);
                } else {
                    // Menampilkan pesan error jika response tidak berhasil
                    Toast.makeText(RoomActivity.this, "Error: " + response.message(), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchRoomResponse> call, Throwable t) {
                // Menampilkan pesan error jika ada kesalahan dalam jaringan
                Toast.makeText(RoomActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        swipeRefresh.setRefreshing(false);
    }


    private void showBottomSheet(Room room) {
        BottomSheetDialog bottomSheetDialog = new BottomSheetDialog(this);
        View view = LayoutInflater.from(this).inflate(R.layout.bottom_sheet_booking, null);
        bottomSheetDialog.setContentView(view);

        EditText etStartDate = view.findViewById(R.id.etStartDate);
        EditText etEndDate = view.findViewById(R.id.etEndDate);
        EditText etHargaBulanan = view.findViewById(R.id.etHargaBulanan);
        EditText etCatatan = view.findViewById(R.id.etCatatan);

        Button btnSave = view.findViewById(R.id.btnSave);
        etHargaBulanan.setText(String.valueOf(room.getHargaBulanan()));
        etStartDate.setOnClickListener(v -> showDatePicker(etStartDate));
        etEndDate.setOnClickListener(v -> showDatePicker(etEndDate));

        btnSave.setOnClickListener(v -> {
            String id_room = room.getId();
            String start_date = etStartDate.getText().toString();
            String end_date = etEndDate.getText().toString();
           String harga_bulanan = etHargaBulanan.getText().toString();
           String catatan = etCatatan.getText().toString();

            Call<BookingResponse> call = ApiClient
                    .getInstance()
                    .getApi()
                    .create(id_customer, id_room, start_date, end_date, harga_bulanan, catatan);


                        call.enqueue(new Callback<BookingResponse>() {
                            @Override
                            public void onResponse(Call<BookingResponse> call, Response<BookingResponse> response) {

                                BookingResponse bookingResponse = response.body();
                                if (bookingResponse.getStatus().equals("true")) {
                                    sukses();

                                } else {
                                    Toast.makeText(RoomActivity.this, bookingResponse.getMessage(), Toast.LENGTH_SHORT).show();
                                }

                            }

                            @Override
                            public void onFailure(Call<BookingResponse> call, Throwable t) {
                                Toast.makeText(RoomActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
                            }

                        });




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
                Intent intent = new Intent(RoomActivity.this, MainActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();
            }
        }).show();

    }
}