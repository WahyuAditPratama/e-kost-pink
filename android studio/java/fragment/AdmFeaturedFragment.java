package com.app.kostpink.fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.app.kostpink.Config;
import com.app.kostpink.R;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.activity.AdmBookingActivity;
import com.app.kostpink.activity.AdmRoomActivity;
import com.app.kostpink.activity.AdmTagihanBookingActivity;
import com.app.kostpink.activity.Laporan;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.google.android.material.bottomnavigation.BottomNavigationView;

public class AdmFeaturedFragment extends Fragment {
    CardView btnRoom, btnBooking, btnTagihan,btnLaporan;
    SharedPrefManager sharedPrefManager;
    String nama, avatar;
    TextView tv_nama;
    ImageView iv_avatar,imgVoucher;
    BottomNavigationView bottomNavigationView;
    String[]arPil={"Transfer","Cash"};


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.adm_fragment_featured, container, false);
    }

    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        sharedPrefManager = new SharedPrefManager(getContext());
        nama = sharedPrefManager.getUser().getNama();
        avatar = sharedPrefManager.getUser().getAvatar();
        tv_nama = view.findViewById(R.id.tv_nama);
        iv_avatar = view.findViewById(R.id.iv_avatar);
        tv_nama.setText("Halo, " + nama);
        Glide.with(getContext()).load(Config.IMAGE_URL + "user/" + avatar).apply(new RequestOptions().override(480, 380)).into(iv_avatar);
        RecyclerView.LayoutManager mLayoutManager = new GridLayoutManager(getContext(), 1, LinearLayoutManager.HORIZONTAL, false);
        btnRoom = view.findViewById(R.id.btn_room);
        btnBooking = view.findViewById(R.id.btn_booking);
        btnTagihan = view.findViewById(R.id.btn_tagihan);
        btnLaporan = view.findViewById(R.id.btn_laporan_bulanan);
        bottomNavigationView = (BottomNavigationView) getActivity().findViewById(R.id.bottomNavigationView);
        btnRoom.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), AdmRoomActivity.class);
                startActivity(i);
            }
        });

        btnBooking.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), AdmBookingActivity.class);
                startActivity(i);
            }
        });
        btnTagihan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), AdmTagihanBookingActivity.class);
                startActivity(i);
            }
        });


        btnLaporan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), Laporan.class);
                startActivity(i);
            }
        });



//        imgVoucher.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                String voucherCode = "PAKAISKG";
//
//                ClipboardManager clipboard = (ClipboardManager) requireActivity().getSystemService(Context.CLIPBOARD_SERVICE);
//                ClipData clip = ClipData.newPlainText("Voucher Code", voucherCode);
//                clipboard.setPrimaryClip(clip);
//
//                Toast.makeText(getActivity(), "Kode voucher disalin: " + voucherCode, Toast.LENGTH_SHORT).show();
//            }
//        });

    }

}